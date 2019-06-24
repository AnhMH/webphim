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
    
    public function crawler() {
        $data = array();
        $urls = array(
            'http://www.danfra.com/series.php',
            'http://www.danfra.com/series.php?page=2',
            'http://www.danfra.com/series.php?page=3',
            'http://www.danfra.com/series.php?page=4',
            'http://www.danfra.com/series.php?page=5'
        );
        $baseUrl = 'http://www.danfra.com/';
        foreach ($urls as $url) {
            // Get website content
            $str = file_get_contents($url);
            // Gets Webpage Internal Links
            $doc = new \DOMDocument;
            @$doc->loadHTML($str);

            $contentNode = $doc->getElementById("wrapper");

            $items = $this->getElementsByClass($contentNode, 'div', 'item-list');
            foreach ($items as $item) {
                $tmp = array();
                $img = array();
                $a = array();
                $h5 = array();
                $img = $this->getElementsByClass($item, 'img', 'thumbnail');
                $h5 = $this->getElementsByClass($item, 'h5', 'add-title');
                foreach ($h5 as $h) {
                    $a = $h->getElementsByTagName("a");
                    $tmp['link'] = $baseUrl.$a[0]->getAttribute('href');
                    $tmp['name'] = $a[0]->textContent;
                }
                $tmp['image'] = $img[0]->getAttribute('src');
                $data[] = $tmp;
            }
        }
        $elements = array(
            'name',
            'link',
            'image'
        );
        $sql = "INSERT IGNORE INTO `crawler_movies` (
                `name`,
                `link`,
                `image`
             ) VALUES ";
        
        $values = array();
        foreach ($data as $v) {
            $values[] = "('{$v['name']}', '{$v['link']}', '{$v['image']}')";
        }
        $sql .= implode(',', $values);
        $dup = array();
        foreach ($elements as $e) {
            $dup[] = "`{$e}` = VALUES({$e})";
        }
        $sql .= " ON DUPLICATE KEY UPDATE " . implode(',', $dup);
        $connection = ConnectionManager::get('default');
        $connection->execute($sql);
        die();
    }
    
    public function crawlermovies() {
        $connection = ConnectionManager::get('default');
        $sql = "SELECT * FROM crawler_movies";
        $data = $connection->execute($sql)->fetchAll('assoc');
        foreach ($data as $v) {
            // Get website content
            $str = file_get_contents($v['link']);
            // Gets Webpage Internal Links
            $doc = new \DOMDocument;
            @$doc->loadHTML($str);

            $contentNode = $doc->getElementById("wrapper");
            
        }
        die();
    }
    
    public function getElementsByClass(&$parentNode, $tagName, $className) {
        $nodes = array();

        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $nodes[]=$temp;
            }
        }
        return $nodes;
    }
}