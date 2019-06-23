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
        $videos = array();
        $server = 0;
        $video = '';
        $ep = '';
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
            $pageTitle = !empty($data['name']) ? $data['name'] : '';
            $pageDescription = !empty($data['meta_description']) ? $data['meta_description'] : '';
            $pageKeyword = !empty($data['tags']) ? $data['tags'] : '';
            $pageImage = !empty($data['image']) ? $data['image'] : '';
            $video = '';
            $ep = !empty($_GET['ep']) ? $_GET['ep'] : '';
            $server = !empty($_GET['s']) ? $_GET['s'] : 0;
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
                $videos = explode("\n", $video);
                $video = $videos[$server];
            }
            $this->set(compact(array(
                'episodes',
                'data',
                'ep',
                'videos',
                'server',
                'video',
                'pageTitle',
                'pageDescription',
                'pageKeyword',
                'pageImage'
            )));
        } else {
            return $this->redirect($this->BASE_URL);
        }
    }
    
    public function search()
    {
        $tag = !empty($_GET['s']) ? $_GET['s'] : '';
        $connection = ConnectionManager::get('default');
        $sql = "SELECT * FROM movies where tags LIKE '%{$tag}%' or name LIKE '%{$tag}%' order by id DESC";
        $movies = $connection->execute($sql)->fetchAll('assoc');
        $this->set(compact(array(
            'movies'
        )));
    }
}