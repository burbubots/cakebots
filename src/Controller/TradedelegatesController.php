<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tradedelegates Controller
 *
 * @property \App\Model\Table\TradedelegatesTable $Tradedelegates
 * @method \App\Model\Entity\Tradedelegate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TradedelegatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tradeaccounts', 'Tradeasociados'],
        ];
        $tradedelegates = $this->paginate($this->Tradedelegates);

        $this->set(compact('tradedelegates'));
    }

    /**
     * View method
     *
     * @param string|null $id Tradedelegate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tradedelegate = $this->Tradedelegates->get($id, [
            'contain' => ['Tradeaccounts', 'Tradeasociados'],
        ]);

        $this->set(compact('tradedelegate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tradedelegate = $this->Tradedelegates->newEmptyEntity();
        if ($this->request->is('post')) {
            $tradedelegate = $this->Tradedelegates->patchEntity($tradedelegate, $this->request->getData());
            if ($this->Tradedelegates->save($tradedelegate)) {
                $this->Flash->success(__('The tradedelegate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradedelegate could not be saved. Please, try again.'));
        }
        $tradeaccounts = $this->Tradedelegates->Tradeaccounts->find('list', ['limit' => 200])->all();
        $tradeasociados = $this->Tradedelegates->Tradeasociados->find('list', ['limit' => 200])->all();
        $this->set(compact('tradedelegate', 'tradeaccounts', 'tradeasociados'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tradedelegate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tradedelegate = $this->Tradedelegates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tradedelegate = $this->Tradedelegates->patchEntity($tradedelegate, $this->request->getData());
            if ($this->Tradedelegates->save($tradedelegate)) {
                $this->Flash->success(__('The tradedelegate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tradedelegate could not be saved. Please, try again.'));
        }
        $tradeaccounts = $this->Tradedelegates->Tradeaccounts->find('list', ['limit' => 200])->all();
        $tradeasociados = $this->Tradedelegates->Tradeasociados->find('list', ['limit' => 200])->all();
        $this->set(compact('tradedelegate', 'tradeaccounts', 'tradeasociados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tradedelegate id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tradedelegate = $this->Tradedelegates->get($id);
        if ($this->Tradedelegates->delete($tradedelegate)) {
            $this->Flash->success(__('The tradedelegate has been deleted.'));
        } else {
            $this->Flash->error(__('The tradedelegate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
