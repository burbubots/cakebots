<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;

class TradeasociadosController extends AppController
{
	const HTTP_OK         = 200;
	const HTTP_NO_CONTENT = 204;
	
	
	public function index($addr=null){
		if( is_null($addr) ) return $this->redirect(['controller'=>'Tradeaccounts', 'action' => 'index']);

		$cuenta = $this->actualizaActivosDesdeRed($addr, $cargagecko=null);
		$this->set('cuenta', $cuenta); // debug
		
        $this->paginate = [
            'contain' => ['Tradeaccounts', 'Tradecoins'],
            'conditions' => ['tradeaccount_id'=>$cuenta->id],
        ];
        $tradeasociados = $this->paginate($this->Tradeasociados);

        $this->set(compact('tradeasociados'));
    }
	
	/*************************************************/
	// Captura los tokens de esta cuenta
	// cuenta se tiene que dar ya de la DB
	public function actualizaActivosDesdeRed($addr, $cargagecko=null){
		$this->loadModel('Tradecoins');

		// cargamos la cuenta que corresponde a $addr
		$this->loadModel('Tradeaccounts');
		$todas_cuentas = $this->Tradeaccounts->find('all',[
				'contain' => [ 'Tradeasociados', 'Tradeasociados.Tradecoins' ],
				'conditions' => [ 'account' => $addr, ], 
			]);
		$cuenta = $todas_cuentas->first(); // es null si no la encuentra
			
		// añadimos a la cuenta los tradecoins presentes en la DB
		$cuenta->todoscoins = [];
		$tcoinsrw = $this->Tradecoins->find('all');
		foreach( $tcoinsrw as $tcoin ) { array_push($cuenta->todoscoins,$tcoin); }

	
		if( !is_null($cuenta)){ // existe
			// info de cuenta
			$params = [$cuenta->account];
			$mi_cuenta_info = $this->curlCaptura("getAccountInfo", json_encode($params));  // CURL
			if( !is_null($mi_cuenta_info)) { // se descargó correctamente
				$sol = $this->buscaPropiedadEnObjetosDeArray($cuenta->tradeasociados, 'associatedAccount' , $addr);
				if( is_null($sol) ){ // no hay una cuenta principal para el token SOL, creamos
					// capturamos el coin que representa a la cuenta principal
					$wsol = $this->buscaPropiedadEnObjetosDeArray($cuenta->todoscoins, 'address' , 'cuenta_principal_solana');
					if(is_null($wsol) ) { // puede que no exista aún, no se da precargada por github
						$wsol = $this->Tradecoins->newEmptyEntity();
						$wsol->coin = 'SOL';
						$wsol->symbol = 'SOL';
						$wsol->address = 'cuenta_principal_solana';
						$wsol->geckoname = 'solana';
						$wsol->small_image = 'https://assets.coingecko.com/coins/images/4128/small/Solana.jpg';
						$this->Tradecoins->save($wsol); // salvamos en base de datos
					}
					// ahora creamos el asociado
					$sol = $this->Tradeasociados->newEmptyEntity();
					$sol->tradeaccount_id = $cuenta->id;
					$sol->tradecoin_id = $wsol->id;
					$sol->associatedAccount = $addr;
					$this->Tradeasociados->save($sol); // salvamos en DB
					$sol->tradecoin = $wsol;
					array_push($cuenta->tradeasociados, $sol);
				}
				if( isset($mi_cuenta_info->result->value->lamports) ){
					$solanas = round( floatval($mi_cuenta_info->result->value->lamports)/pow(10,9),9); // salvamos solanas
					$sol->balance = $solanas;
					$this->Tradeasociados->save($sol); // salvamos solanas en cuenta principal
				}
			}
			
			// cargando tokens de cuenta desde la red
			$cuenta->tokens_red = [];
			$params = [ $cuenta->account, 
				array('programId' => 'TokenkegQfeZyiNwAJbNbGKPFXCWuBvf9Ss623VQ5DA'),
				array('encoding' => 'jsonParsed', 'commitment' => 'processed'), 
			];
			$tokensred = $this->curlCaptura("getTokenAccountsByOwner", json_encode($params)); //CURL
			/*$this->set('tkred_00',$tokensred->result->value[0]->account->data->parsed->info);
			$this->set('tkred_01',$tokensred->result->value[1]->account->data->parsed->info);
			$this->set('tkred_02',$tokensred->result->value[2]->account->data->parsed->info);
			$this->set('tkred_03',$tokensred->result->value[3]->account->data->parsed->info);
			$this->set('tkred_04',$tokensred->result->value[4]->account->data->parsed->info);
			$this->set('tkred_05',$tokensred->result->value[5]->account->data->parsed->info);*/
			if( !is_null($tokensred) ){ // no ha habido problema con la captura en https://free.rpcpool.com
				$contador = 0;
				foreach($tokensred->result->value as $tred){  // recorremos los tokens de red
					if( isset($tred->account->data->parsed->info->delegate) ){ // es token delegado
						$this->Flash->success(json_encode($tred->account->data->parsed->info) );
						
					}
					$address = $tred->pubkey;
					//$this->Flash->success('Busco: '.$address);
					
					$mint_red = $this->procesaTokenMint($tred);
					$mitoken = $this->buscaPropiedadEnObjetosDeArray($cuenta->tradeasociados, 'associatedAccount' , $address);

					// creamos el token asociado,si no existe
					if( is_null($mitoken) && !is_null($mint_red) ){
						
						//$tradecoinsrw = $this->Tradecoins->find('all', [ 'conditions' => ['address'=>$mint_red] ]);
						//$tradecoin = $tradecoinsrw->first(); // es null si no la encuentra
						$tradecoin = $this->buscaPropiedadEnObjetosDeArray($cuenta->todoscoins, 'address', $mint_red);
						
						if( is_null($tradecoin) ){ // este token que está registrado en la red, no lo tenemos en la DB, lo creamos
							// $this->Flash->success('Crear '.$address.' Mint: '.$mint_red); // debug
							$tradecoin = $this->Tradecoins->newEmptyEntity();
							$tradecoin->coin = 'Desconocido';
							$tradecoin->symbol = 'NO_SE';
							$tradecoin->address = $mint_red;
							$this->Tradecoins->save($tradecoin);
							array_push($cuenta->todoscoins, $tradecoin);
						}
						// Ahora creamos el token asociado en la tabla Tradeasociados, conectado a su mint-address (tabla Tradecoins)
						$mitoken = $this->Tradeasociados->newEmptyEntity();
						$mitoken->associatedAccount = $address; // el addrees de asociado descargado de blockchain
						$mitoken->tradecoin_id = $tradecoin->id;  // puntero al coin
						$mitoken->tradeaccount_id = $cuenta->id;  // puntero a la cuenta
						$this->Tradeasociados->save($mitoken);  // salvando a la DB
						
						$mitoken->tradecoin = $tradecoin; // conectamos a pelo el objeto
						
						array_push($cuenta->tradeasociados,$mitoken); // añadimos al array
					}
					
					if(!is_null($mint_red) ){ //hay datos, actualizamos el token
						// chequeo previo de mintados
						if( $mint_red != $mitoken->tradecoin->address ){ 
							$this->Flash->error( 'Mintados no coinciden !! '.$mint_red); // este es un error demasiado gordo, anulamos
							return null; 
						}
						// Identificación del token con una lista de conocidos
						if( !isset($cuenta->conocidos) ){ // cargamos si no está definido
							$cuenta->conocidos = $this->cargatokensConocidos()->tokens;
							//$cuenta->damedatos = []; // para debug
						}
						if($mitoken->tradecoin->coin == 'Desconocido'){ // no está identificado
							// buscamos el address del mintado entre los conocidos, para identificar el token
							$busco = $this->buscaPropiedadEnObjetosDeArray($cuenta->conocidos, 'address' , $mitoken->tradecoin->address);
							if( !is_null($busco) ) { // tenemos datos, es conocido
//								array_push($cuenta->damedatos, ['name'=>$busco->name ]); // para debug
								$mitoken->tradecoin->coin = $busco->name;
								$mitoken->tradecoin->symbol = $busco->symbol;
								$mitoken->tradecoin->small_image = $busco->logoURI;
								$this->Tradecoins->save($mitoken->tradecoin); // guardamos en DB, tabla Tradecoins
							}
						}
						
						// balance 
						$nuevo_balance = $this->procesaTokenBalance($tred);
						if($mitoken->balance != $nuevo_balance){
							$mitoken->balance = $nuevo_balance;
							$this->Tradeasociados->save($mitoken);
						}
					}else{
						$this->Flash->error('No hay datos del token');
						return null;
					}
					$contador++;
				}
			}
			
			// actualizando valores USD si así se determina en la configuración
			if( !is_null($cargagecko) ){
				foreach($cuenta->tradeasociados as $asoc){
					if( !is_null($asoc->tradecoin->geckoname) && $asoc->tradecoin->getticker == 1 && $asoc->tradecoin->balance > 0){
						$this->actualizaConCoingecko($asoc);
					}
				}
			}
			
			//$this->set('infocuenta', $mi_cuenta_info->result);
			//$this->set('cuenta', $cuenta);
		} // addr existe, existe $cuenta
		
		return $cuenta;
	}
		
	/**************************************************************************/
	// Actualiza datos de un asociado con los datos de la API de Coingecko
	private function actualizaConCoingecko($asoc){
		$this->loadModel('Tradecoins');
		$client = new CoinGeckoClient();
		$data = $client->coins()->getCoin($asoc->tradecoin->geckoname, ['tickers' => 'false', 'market_data' => 'true']);

		$asoc->tradecoin->symbol = strtoupper($data['symbol']);
		$asoc->tradecoin->name = $data['name'];
		$asoc->tradecoin->valorusd = $data['market_data']['current_price']['usd'];
		$asoc->tradecoin->acumusd = round($asoc->tradecoin->valorusd*$asoc->tradecoin->balance,2);
		
		if( is_null($asoc->tradecoin->small_image) ){
			$asoc->tradecoin->small_image = $data['image']['small'];
		}
		
		$asoc->tradecoin->inc24h = round($data['market_data']['price_change_percentage_24h'],2);
        $asoc->tradecoin->inc7d = round($data['market_data']['price_change_percentage_7d'],2);
        $asoc->tradecoin->inc14d = round($data['market_data']['price_change_percentage_14d'],2);
        $asoc->tradecoin->inc30d = round($data['market_data']['price_change_percentage_30d'],2);
        $asoc->tradecoin->inc60d = round($data['market_data']['price_change_percentage_60d'],2);
		if(!is_null($data['market_data']['max_supply'])) $asoc->tradecoin->max_supply = round($data['market_data']['max_supply']/1e6,2);
        if(!is_null($data['market_data']['total_supply'])) $asoc->tradecoin->total_supply = round($data['market_data']['total_supply']/1e6,2);
        if(!is_null($data['market_data']['circulating_supply'])) $asoc->tradecoin->circulating_supply = round($data['market_data']['circulating_supply']/1e6,2);
		
		$this->Tradecoins->save($asoc->tradecoin);		
		
		$this->set('data', $data);
	}
	
	/**************************************************************************/
	// Procesa los datos crudos, para devolver el token de forma más usable
	private function procesaTokenMint($tred){
		if( isset($tred->account->data->parsed->info->mint) ){
			$mint = $tred->account->data->parsed->info->mint;
			return $mint;
		}
		return null;
	}

	/**************************************************************************/
	// Procesa los datos crudos, para devolver el token de forma más usable
	private function procesaTokenBalance($tred){
		if( isset($tred->account->data->parsed->info->tokenAmount->uiAmountString) ){
			$balance = floatval($tred->account->data->parsed->info->tokenAmount->uiAmountString);
			return $balance;
		}
		return 0;
	}

	/**************************************************************************/
	// Carga y devuelve los tokens conocidos de una lista enorme
    private function cargatokensConocidos(){
		$url = 'todosTokens.json';
		$options = array(
			'http'=>array(
			'method'=>"GET",
			'header'=>"Accept-language: es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3\r\n" .
						"Connection: keep-alive\r\n".
						"Content-Type: application/json\r\n".
						"Host: prod-api.solana.surf\r\n".
						"Origin: https://solanabeach.io\r\n".
						"Referer: https://prod-api.solana.surf/".
						"TE: Trailers\r\n".
						"User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0\r\n"
			)
		);
		$context = stream_context_create($options);
		$file = file_get_contents($url, false, $context);
		//$this->Flash->success('Capturado '.$url);
		return json_decode($file);
	}



    public function view($id = null){
        $tradeasociado = $this->Tradeasociados->get($id, [
            'contain' => ['Tradeaccounts', 'Tradecoins',],
        ]);

        $this->set(compact('tradeasociado'));
    }

    public function add(){
        $tradeasociado = $this->Tradeasociados->newEmptyEntity();
        if ($this->request->is('post')) {
            $tradeasociado = $this->Tradeasociados->patchEntity($tradeasociado, $this->request->getData());
            if ($this->Tradeasociados->save($tradeasociado)) {
                $this->Flash->success(__('The tradeasociado has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradeasociado could not be saved. Please, try again.'));
        }
        $tradeaccounts = $this->Tradeasociados->Tradeaccounts->find('list', ['limit' => 200]);
        $tradecoins = $this->Tradeasociados->Tradecoins->find('list', ['limit' => 200]);
        $this->set(compact('tradeasociado', 'tradeaccounts', 'tradecoins'));
    }

    public function edit($id = null){
        $tradeasociado = $this->Tradeasociados->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tradeasociado = $this->Tradeasociados->patchEntity($tradeasociado, $this->request->getData());
            if ($this->Tradeasociados->save($tradeasociado)) {
                $this->Flash->success(__('The tradeasociado has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradeasociado could not be saved. Please, try again.'));
        }
        $tradeaccounts = $this->Tradeasociados->Tradeaccounts->find('list', ['limit' => 200]);
        $tradecoins = $this->Tradeasociados->Tradecoins->find('list', ['limit' => 200]);
        $this->set(compact('tradeasociado', 'tradeaccounts', 'tradecoins'));
    }

    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $tradeasociado = $this->Tradeasociados->get($id);
        if ($this->Tradeasociados->delete($tradeasociado)) {
            $this->Flash->success(__('The tradeasociado has been deleted.'));
        } else {
            $this->Flash->error(__('The tradeasociado could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    // busca en un array de objetos uno que tenga la propiedad a un valor. Devuelve objeto o null
	private function buscaPropiedadEnObjetosDeArray($arrayobjs, $nombrepropiedad, $valor){
		foreach($arrayobjs as $obj){
			if( isset($obj->$nombrepropiedad) ){
				if($obj->$nombrepropiedad == $valor) return $obj;
			}
		}
		return null;
	}
    
    private function curlCaptura($orden, $payload, $decode=true){

		$uri = 'https://free.rpcpool.com';
		$timeout = (float) 2; // segundos
		
		   // init curl options
        $options = [
                CURLOPT_HTTPHEADER        => ["Content-Type: application/json",],
                CURLOPT_RETURNTRANSFER    => true,
                CURLOPT_URL               => $uri,
                CURLOPT_POST              => true,
                CURLOPT_FOLLOWLOCATION    => false,
                CURLOPT_TIMEOUT_MS        => (int)($timeout * 1000),
            ];

        $curl = curl_init();
		$cadena = "{\"jsonrpc\":\"2.0\",".
				"\"id\":\"1\",".
				"\"method\":\"".$orden."\",".
				"\"params\":".$payload."}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $cadena );
				
        curl_setopt_array($curl, $options);
        
        $response  = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error     = curl_error($curl);
        curl_close($curl);

        if (false === $response) {
			$this->Flash->error('Unable to connect to '.$uri.', reason: '.$error);
			return null;
        }

        if ($http_code !== self::HTTP_OK && $http_code !== self::HTTP_NO_CONTENT) {
			$this->Flash->error('Unable to connect to '.$uri.', Invalid status code: '.$http_code);
			return null;
        }
		if(isset($decode)) return json_decode($response);
		else return $response;
	}

}
