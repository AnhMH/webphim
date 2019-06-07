<?php

namespace App\Controller;

class AdminsController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $admins = $this->Paginator->paginate($this->Admins->find());
        $this->set(compact('admins'));
    }
    
    public function view($id = null)
    {
        $admin = $this->Admins->findById($id)->firstOrFail();
        $this->set(compact('admin'));
    }
    
    public function add()
    {
        $admin = $this->Admins->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
//            $admin->user_id = 1;

            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('Your admin has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your admin.'));
        }
        $this->set('admin', $admin);
    }
    
    public function edit($id)
    {
        $admin = $this->Admins->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('Your admin has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your admin.'));
        }

        $this->set('admin', $admin);
    }
    
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $admin = $this->Admins->findById($id)->firstOrFail();
        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The {0} admin has been deleted.', $admin->name));
            return $this->redirect(['action' => 'index']);
        }
    }
}