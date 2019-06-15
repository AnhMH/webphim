<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;


class VideosController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow();
    }
    
    public function detail($slug = '')
    {
        $video = '';
        $connection = ConnectionManager::get('default');
        $movieModel = TableRegistry::get('Movies');
        $sqlDetail = "SELECT 
    countries.name AS cate_name,
    countries.slug AS cate_slug,
    movies.*
FROM
    movies
        LEFT JOIN
    countries ON countries.id = movies.country_id
WHERE
    movies.slug = '{$slug}'";
        $data = $connection->execute($sqlDetail)->fetchAll('assoc');
        if (!empty($data[0])) {
            $data = $data[0];
            $ep = !empty($_GET['ep']) ? $_GET['ep'] : '';
            $sqlEpisodes = "SELECT * FROM episodes WHERE movie_id = {$data['id']}";
            $episodes = $connection->execute($sqlEpisodes)->fetchAll('assoc');
            if (!empty($episodes)) {
                if (empty($ep)) {
                    $ep = $episodes[0]['id'];
                    $video = $episodes[0]['servers'];
                } else {
                    foreach ($episodes as $v) {
                        if ($v['id'] == $ep) {
                            $video = $v['servers'];
                            break;
                        }
                    }
                }
            }
            $this->set(compact(array(
                'episodes',
                'data',
                'ep',
                'video'
            )));
        } else {
            return $this->redirect($this->BASE_URL);
        }
    }
}