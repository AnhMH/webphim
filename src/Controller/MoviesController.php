<?php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class MoviesController extends AppController {

    public function index() {
        $this->loadComponent('Paginator');
        $data = $this->Paginator->paginate($this->Movies->find());
        $this->set(compact('data'));
    }

    public function view($id = null) {
        $data = $this->Movies->findById($id)->firstOrFail();
        $this->set(compact('data'));
    }

    public function add() {
        $data = $this->Movies->newEntity();
        $time = time();
        if ($this->request->is('post')) {
            $data = $this->Movies->patchEntity($data, $this->request->getData());
            $data->slug = $this->convertURL($data->name);
            $data->created = $time;
            $data->updated = $time;
            
            $image = $this->request->data['image'];
            if (!empty($image) && is_array($image)) {
                $ext = substr(strtolower(strrchr($image['name'], '.')), 1); //get the extension
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                //only process if the extension is valid
                if(in_array($ext, $arr_ext))
                {
                    $imageName = $data->slug.'-'.time();
                    
                    move_uploaded_file($image['tmp_name'], WWW_ROOT . '/images/movies/' . $imageName);

                    //prepare the filename for database entry
                    $data->image = $this->BASE_URL.'/images/movies/'.$imageName;
                }
            }
            if ($this->Movies->save($data)) {
                $this->Flash->success(__('Your movie has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your movie.'));
        }
        $this->set('data', $data);
    }

    public function edit($id) {
        $data = $this->Movies->findById($id)->firstOrFail();
        $time = time();
        if ($this->request->is(['post', 'put'])) {
            $this->Movies->patchEntity($data, $this->request->getData());
            
            // Modify data
            $data->slug = $this->convertURL($data->name);
            $data->updated = $time;
            
            // Upload image
            $image = $this->request->data['image2'];
            if (!empty($image) && is_array($image)) {
                $ext = substr(strtolower(strrchr($image['name'], '.')), 1); //get the extension
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                //only process if the extension is valid
                if(in_array($ext, $arr_ext))
                {
                    $imageName = $data->slug.'-'.$time;
                    
                    move_uploaded_file($image['tmp_name'], WWW_ROOT . '/images/movies/' . $imageName);

                    //prepare the filename for database entry
                    $data->image = $this->BASE_URL.'/images/movies/'.$imageName;
                }
            }
            
            // Save data
            if ($this->Movies->save($data)) {
                $this->Flash->success(__('Your movie has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your movie.'));
        }

        $this->set('data', $data);
    }

    public function delete($id) {
        $this->request->allowMethod(['post', 'delete']);

        $data = $this->Movies->findById($id)->firstOrFail();
        if ($this->Movies->delete($data)) {
            $this->Flash->success(__('The {0} movie has been deleted.', $data->name));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    public function crawl() {
        $sql = "SELECT * FROM crawler_movies";
        $connection = ConnectionManager::get('default');
        $data = $connection->execute($sql)->fetchAll('assoc');
        foreach ($data as $v) {
            $time = time();
            $movie = $this->Movies->newEntity();
            $movie = $this->Movies->patchEntity($movie, $v);
            $movie->slug = $this->convertURL($movie->name);
            $movie->created = $time;
            $movie->updated = $time;
            $this->Movies->save($movie);
        }
        die('DONE');
    }

}
