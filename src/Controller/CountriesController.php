<?php

namespace App\Controller;

class CountriesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $data = $this->Paginator->paginate($this->Countries->find());
        $this->set(compact('data'));
    }
    
    public function view($id = null)
    {
        $data = $this->Countries->findById($id)->firstOrFail();
        $this->set(compact('data'));
    }
    
    public function add()
    {
        $data = $this->Countries->newEntity();
        if ($this->request->is('post')) {
            $data = $this->Countries->patchEntity($data, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
//            $data->user_id = 1;
            $data->slug = $this->convertURL($data->name);

            if ($this->Countries->save($data)) {
                $this->Flash->success(__('Your country has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your country.'));
        }
        $this->set('data', $data);
    }
    
    public function edit($id)
    {
        $data = $this->Countries->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Countries->patchEntity($data, $this->request->getData());
            if ($this->Countries->save($data)) {
                $this->Flash->success(__('Your country has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your country.'));
        }

        $this->set('data', $data);
    }
    
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $data = $this->Countries->findById($id)->firstOrFail();
        if ($this->Countries->delete($data)) {
            $this->Flash->success(__('The {0} country has been deleted.', $data->name));
            return $this->redirect(['action' => 'index']);
        }
    }
}