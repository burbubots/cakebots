<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tradeaccounts Controller
 *
 * @property \App\Model\Table\TradeaccountsTable $Tradeaccounts
 * @method \App\Model\Entity\Tradeaccount[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TradeaccountsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $tradeaccounts = $this->paginate($this->Tradeaccounts);

        $this->set(compact('tradeaccounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Tradeaccount id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tradeaccount = $this->Tradeaccounts->get($id, [
            'contain' => ['Tradeasociados', 'Tradeasociados.Tradecoins'],
        ]);

        $this->set(compact('tradeaccount'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tradeaccount = $this->Tradeaccounts->newEmptyEntity();
        if ($this->request->is('post')) {
            $tradeaccount = $this->Tradeaccounts->patchEntity($tradeaccount, $this->request->getData());
            if ($this->Tradeaccounts->save($tradeaccount)) {
                $this->Flash->success(__('The tradeaccount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradeaccount could not be saved. Please, try again.'));
        }
        $this->set(compact('tradeaccount'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tradeaccount id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tradeaccount = $this->Tradeaccounts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tradeaccount = $this->Tradeaccounts->patchEntity($tradeaccount, $this->request->getData());
            if ($this->Tradeaccounts->save($tradeaccount)) {
                $this->Flash->success(__('The tradeaccount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradeaccount could not be saved. Please, try again.'));
        }
        $this->set(compact('tradeaccount'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tradeaccount id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tradeaccount = $this->Tradeaccounts->get($id);
        if ($this->Tradeaccounts->delete($tradeaccount)) {
            $this->Flash->success(__('The tradeaccount has been deleted.'));
        } else {
            $this->Flash->error(__('The tradeaccount could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
