<?php

namespace App\Controller;

class EpisodesController extends AppController {

    public function index() {
        $movieId = !empty($_GET['movie_id']) ? $_GET['movie_id'] : '';
        if (!empty($movieId)) {
            $data = $this->Episodes->find()->where(['movie_id' => $movieId])->toList();
        } else {
            $data = $this->Episodes->find()->toList();
        }
        $this->set(compact(array(
            'data',
            'movieId'
        )));
    }

    public function view($id = null) {
        $data = $this->Episodes->findById($id)->firstOrFail();
        $this->set(compact('data'));
    }

    public function add($movieId = '') {
        $data = $this->Episodes->newEntity();
        $time = time();
        if ($this->request->is('post')) {
            $data = $this->Episodes->patchEntity($data, $this->request->getData());
            $data->slug = $this->convertURL($data->name);
            $data->movie_id = $movieId;
            $data->created = $time;
            $data->updated = $time;
            
            if ($this->Episodes->save($data)) {
                $this->Flash->success(__('Your episode has been saved.'));
                $url = $this->BASE_URL.'/episodes?movie_id='.$movieId;
                return $this->redirect($url);
            }
            $this->Flash->error(__('Unable to add your Episode.'));
        }
        $this->set('data', $data);
    }

    public function edit($id) {
        $data = $this->Episodes->findById($id)->firstOrFail();
        $time = time();
        if ($this->request->is(['post', 'put'])) {
            $this->Episodes->patchEntity($data, $this->request->getData());
            
            // Modify data
            $data->slug = $this->convertURL($data->name);
            $data->updated = $time;
            
            // Save data
            if ($this->Episodes->save($data)) {
                $this->Flash->success(__('Your movie has been updated.'));
                $url = $this->BASE_URL.'/episodes?movie_id='.$data->movie_id;
                return $this->redirect($url);
            }
            $this->Flash->error(__('Unable to update your Episode.'));
        }

        $this->set('data', $data);
    }

    public function delete($id) {
        $this->request->allowMethod(['post', 'delete']);

        $data = $this->Episodes->findById($id)->firstOrFail();
        if ($this->Episodes->delete($data)) {
            $this->Flash->success(__('The {0} Episode has been deleted.', $data->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}
