<?php
declare(strict_types=1);

namespace App\Controller;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;


class TradecoinsController extends AppController
{

    public function index($addr=null)
    {
		if( is_null($addr) ) return $this->redirect(['controller'=>'Tradeaccounts', 'action' => 'index']);
		
	
		// actualizamos
		$asoc_ctrl = new TradeasociadosController;  // creamos el controlador
		$cuenta = $asoc_ctrl->actualizaActivosDesdeRed($addr,true);
		
		$this->set('cuenta', $cuenta);
		
        $this->paginate = [ 
            'contain' => ['Tradeasociados','Tradeasociados.Tradeaccounts',],
            //'conditions' => [ 'tradeaccount_id'=>1],
        ];
        $tradecoins = $this->paginate($this->Tradecoins);
        
        foreach($tradecoins->items as $coin){
			foreach($coin->tradeasociados as $assoc){
				$this->Flash->success('jolas');
//				if( $assoc->tradeaccount_id != $cuenta->id) {
				if( $assoc->tradeaccount_id != 2) {
					unset($assoc);
					
				}
			}
		}
 
        $this->set(compact('tradecoins'));
    }


    public function view($id = null)
    {
        $tradecoin = $this->Tradecoins->get($id, [
            'contain' => ['Tradeasociados','Tradeasociados.Tradeaccounts',],
        ]);

        $this->set(compact('tradecoin'));
    }

    
    public function add()
    {
        $tradecoin = $this->Tradecoins->newEmptyEntity();
        if ($this->request->is('post')) {
            $tradecoin = $this->Tradecoins->patchEntity($tradecoin, $this->request->getData());
            if ($this->Tradecoins->save($tradecoin)) {
                $this->Flash->success(__('The tradecoin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradecoin could not be saved. Please, try again.'));
        }
        $this->set(compact('tradecoin'));
    }


    public function edit($id = null)
    {
        $tradecoin = $this->Tradecoins->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tradecoin = $this->Tradecoins->patchEntity($tradecoin, $this->request->getData());
            if ($this->Tradecoins->save($tradecoin)) {
                $this->Flash->success(__('The tradecoin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradecoin could not be saved. Please, try again.'));
        }
        $this->set(compact('tradecoin'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tradecoin = $this->Tradecoins->get($id);
        if ($this->Tradecoins->delete($tradecoin)) {
            $this->Flash->success(__('The tradecoin has been deleted.'));
        } else {
            $this->Flash->error(__('The tradecoin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
