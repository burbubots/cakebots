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
            'contain' => ['Tradeaccounts', 'Tradecoins', 'Tradedelegates'],
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
				'contain' => [ 'Tradeasociados', 'Tradeasociados.Tradecoins', 'Tradeasociados.Tradedelegates' ],
				'conditions' => [ 'account' => $addr, ], 
			]);
		$cuenta = $todas_cuentas->first(); // es null si no la encuentra
			
		// añadimos a la cuenta los tradecoins presentes en la DB
		$cuenta->todoscoins = [];
		$tcoinsrw = $this->Tradecoins->find('all');
		foreach( $tcoinsrw as $tcoin ) { array_push($cuenta->todoscoins,$tcoin); }

	
		if( !is_null($cuenta)){ // existe
			// info de cuenta  getAccountInfo
			$params = [$cuenta->account];
			$mi_cuenta_info = $this->curlCaptura("getAccountInfo", json_encode($params));  // CURL
			if( !is_null($mi_cuenta_info)) { // se descargó correctamente
				// creando el token de la cuenta principal
				$busco = ['address'=>'cuenta_principal_solana']; // busco la asociada para mi cuenta principal
				$actualizo = ['coin'=>'SOL', 'symbol'=>'SOL', 'geckoname'=>'solana', 
								'small_image'=>'https://assets.coingecko.com/coins/images/4128/small/Solana.jpg']; // datos que ha de tener
				$cuenta->todoscoins = $this->creaActualiza('Tradecoins', $busco, $actualizo, $cuenta->todoscoins); // creo o actualizo si existe
				$wsol = $this->buscaMultiplesPropiedadesEnObjetosDeArray($cuenta->todoscoins, ['address'=>'cuenta_principal_solana']);
				
				// creando o actualizando el token asociado
				if( isset($mi_cuenta_info->result->value->lamports) ){ // tenemos el saldo en solanas de la cuenta principal
					$solanas = round( floatval($mi_cuenta_info->result->value->lamports)/pow(10,9),9); // salvamos solanas
					$actualizo = ['balance'=>$solanas]; // actualizamos el balance de SOL de la cuenta principal
				}else{
					$actualizo=[]; 
				}
				$busco = ['associatedAccount'=>$addr, 'tradeaccount_id'=>$cuenta->id, 'tradecoin_id'=>$wsol->id]; // busco la asociada para mi cuenta principal
				$cuenta->tradeasociados = $this->creaActualiza('Tradeasociados', $busco, $actualizo, $cuenta->tradeasociados);// creo o actualizo si existe
				$sol = $this->buscaMultiplesPropiedadesEnObjetosDeArray($cuenta->tradeasociados,
										['associatedAccount'=>$addr, 'tradeaccount_id'=>$cuenta->id, 'tradecoin_id'=>$wsol->id] ); 
 			}
			
			// cargando tokens de cuenta desde la red  getTokenAccountsByOwner
			$params = [ $cuenta->account, 
				array('programId' => 'TokenkegQfeZyiNwAJbNbGKPFXCWuBvf9Ss623VQ5DA'),
				array('encoding' => 'jsonParsed', 'commitment' => 'processed'), 
			];
			$tokensred = $this->curlCaptura("getTokenAccountsByOwner", json_encode($params)); //CURL
		
			if( !is_null($tokensred) ){ // no ha habido problema con la captura en https://free.rpcpool.com
				$contador = 0;
				foreach($tokensred->result->value as $tred){  // recorremos los tokens de red
					$address = $tred->pubkey;
					$mint_red = $this->procesaTokenMint($tred);

					// creamos el token asociado,si no existe
					if( !is_null($mint_red) ){
						// $cuenta->todoscoins posee todos los objetos de la tabla tradecoins. Buscamos el mint de ese token
						$tradecoin = $this->buscaPropiedadEnObjetosDeArray($cuenta->todoscoins, 'address', $mint_red);
						
						if( is_null($tradecoin) ){ // este token que está registrado en la red, no lo tenemos en la DB, lo creamos
							$busco = ['address'=>$mint_red];
							$actualizo = ['coin' => 'Desconocido', 'symbol' => 'NO_SE', 'address' => $mint_red];
							$cuenta->todoscoins = $this->creaActualiza('Tradecoins', $busco, $actualizo, $cuenta->todoscoins); // creo
							$tradecoin = $this->buscaPropiedadEnObjetosDeArray($cuenta->todoscoins, 'address', $mint_red);
						}
					}
					// Ahora creamos el token asociado en la tabla Tradeasociados, conectado a su mint-address (tabla Tradecoins)
					$busco = ['associatedAccount'=>$address, 'tradecoin_id'=>$tradecoin->id, 'tradeaccount_id'=>$cuenta->id];
					$actualizo = [];
					$cuenta->tradeasociados = $this->creaActualiza('Tradeasociados', $busco, $actualizo, $cuenta->tradeasociados); // creo o actualizo
					$mitoken = $this->buscaPropiedadEnObjetosDeArray($cuenta->tradeasociados, 'associatedAccount' , $address);
					$mitoken->tradecoin = $tradecoin; // conectamos a pelo el objeto								
					
					if(!is_null($mint_red) ){ //hay datos, actualizamos el token

						// captura de las cantidades de token delegadas (stake)
						if( isset($tred->account->data->parsed->info->delegate) ){ // es token delegado
							//$this->Flash->success(json_encode($tred->account->data->parsed->info) ); // debug
							//$this->set('tkred_'.$contador,$tred->account->data->parsed->info); // debug
							$info = $tred->account->data->parsed->info;
							// Creamos o actualizamos el delegate
							$busco = ['delegate' => $info->delegate, 'tradeaccount_id'=>$cuenta->id , 'tradeasociado_id'=>$mitoken->id];
							$actualizo = ['cantidad'=> $info->delegatedAmount->uiAmountString];
							$mitoken->tradedelegates = $this->creaActualiza('Tradedelegates', $busco, $actualizo, $mitoken->tradedelegates); // creo o actualizo
						}
						
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
						// Identificación de tokens que sean desconocidos, con sus símbolos y logo, a partir de su address
						if($mitoken->tradecoin->coin == 'Desconocido'){ 
							$buscotoken = $this->buscaPropiedadEnObjetosDeArray($cuenta->conocidos, 'address' , $mitoken->tradecoin->address);
							if( !is_null($buscotoken) ) { // tenemos datos, es un token de los muchos conocidos
//								array_push($cuenta->damedatos, ['name'=>$buscotoken->name ]); // para debug
								$mitoken->tradecoin->coin = $buscotoken->name;
								$mitoken->tradecoin->symbol = $buscotoken->symbol;
								$mitoken->tradecoin->small_image = $buscotoken->logoURI;
								$this->Tradecoins->save($mitoken->tradecoin); // guardamos en DB, tabla Tradecoins
							}
						}
						
						// balance del token asociado
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
	
	/*******************************************************************/
	// A un array de objetos se le busca uno con condiciones en $busco, creándose si no existe
	// Si existe, se chequean sus variables contebnidas en $masvar, a ver han cambiado, actualizándose
	// Devuelve el array
	private function creaActualiza($clase, $busco, $masvar, $arrayObjs){
		
		$this->loadModel($clase);
		
		$objetivo = $this->$clase->newEmptyEntity();
		$keys = array_keys($busco);
		
		foreach($keys as $prop){
			$objetivo->$prop = $busco[$prop];
		}
		
		if(!isset($arrayObjs) ) {
			//$this->Flash->error( 'Array de clase '.$clase.' no estaba actualizado.');
			$arrayObjs=[];
		}
		
		$encontrado = $this->buscaMultiplesPropiedadesEnObjetosDeArray($arrayObjs,$busco);
			
		if( is_null($encontrado) ){ // no está, debemos crearlo
			if( !is_null($masvar) ){
				$maskeys = array_keys($masvar);
				foreach($maskeys as $prop){
					$objetivo->$prop = $masvar[$prop];
				}
			}
			$this->$clase->save($objetivo);
			//$this->Flash->success('Creando...');
			array_push($arrayObjs,$objetivo);
			
		}else{ // sí que existe lo que buscamos, actualizamos
			if( !is_null($masvar) ){
				$maskeys = array_keys($masvar);
				foreach($maskeys as $prop){
					$objetivo->$prop = $masvar[$prop];
				}
			
				$cambia = false;
				foreach($maskeys as $prop){
					if( $objetivo->$prop != $encontrado->$prop ) $cambia=true;
				}
				if($cambia){  // SOLO ACTUALIZAMOS SI CAMBIA
					foreach($maskeys as $prop){
						$encontrado->$prop = $masvar[$prop];
					}
					$this->$clase->save($encontrado);
					$this->Flash->error('Actualizando ID:'.$encontrado->id.' '.json_encode($masvar) );
				}
			} 
		}
		return $arrayObjs;
	}
	
	/********************************************************************************/
	// busca en un array de objetos uno que tenga las propiedades en un array (propsarray). 
	// Devuelve el primer objeto que las cumple.
	private function buscaMultiplesPropiedadesEnObjetosDeArray($arrayobjs, $props_array){
		$keys = array_keys($props_array);

		foreach($arrayobjs as $obj){
			$cumple_todas = true;  // todas las propiedades las cumple
			foreach($keys as $prop ){
				if( isset($obj->$prop) ){
					if( $obj->$prop != $props_array[$prop] ){
						$cumple_todas = false;
					} 
				} else{
					$cumple_todas = false;
				}
			}
			if( $cumple_todas){
				 return $obj;
			}
		}
		return null;
	}

}
