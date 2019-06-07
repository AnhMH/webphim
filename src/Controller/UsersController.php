<?php

namespace App\Controller;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['logout', 'add']);
    }

    public function logout() {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function index() {
        $this->loadComponent('Paginator');
        $admins = $this->Paginator->paginate($this->Users->find());
        $this->set(compact('admins'));
    }

    public function view($id = null) {
        $admin = $this->Users->findById($id)->firstOrFail();
        $this->set(compact('admin'));
    }

    public function add() {
        $admin = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Users->patchEntity($admin, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
//            $admin->user_id = 1;

            if ($this->Users->save($admin)) {
                $this->Flash->success(__('Your admin has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your admin.'));
        }
        $this->set('admin', $admin);
    }

    public function edit($id) {
        $admin = $this->Users->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($admin, $this->request->getData());
            if ($this->Users->save($admin)) {
                $this->Flash->success(__('Your admin has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your admin.'));
        }

        $this->set('admin', $admin);
    }

    public function delete($id) {
        $this->request->allowMethod(['post', 'delete']);

        $admin = $this->Users->findById($id)->firstOrFail();
        if ($this->Users->delete($admin)) {
            $this->Flash->success(__('The {0} admin has been deleted.', $admin->name));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

}
