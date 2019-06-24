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
        $result = array();
        $baseUrl = 'http://www.danfra.com/';
        $connection = ConnectionManager::get('default');
        $sql = "SELECT * FROM crawler_movies";
        $data = $connection->execute($sql)->fetchAll('assoc');
        foreach ($data as $v) {
            $name = trim($v['name']);
            $tmp = array(
                'name' => $name,
                'image' => $v['image'],
                'slug' => $this->convertURL($name)
            );
            // Get website content
            $str = file_get_contents($v['link']);
            // Gets Webpage Internal Links
            $doc = new \DOMDocument;
            @$doc->loadHTML($str);
            $contentNode = $doc->getElementById("wrapper");
            
            $episodes = array();
            $panelBody = $this->getElementsByClass($contentNode, 'div', 'panel-body');
            foreach ($panelBody as $p) {
                $ep = $p->getElementsByTagName("a");
                $episodes[] = array(
                    'link' => $baseUrl.$ep[0]->getAttribute('href'),
                    'name' => trim(str_replace($name, '', $ep[0]->textContent))
                );
            }
            
            $fieldSet = $contentNode->getElementsByTagName("fieldset");
            $tmp['description'] = trim($fieldSet[2]->getElementsByTagName("p")[0]->textContent);
            $tmp['episodes'] = json_encode($episodes, JSON_UNESCAPED_UNICODE);
            $result[] = $tmp;
        }
        
        $elements = array(
            'name',
            'slug',
            'image',
            'episodes',
            'last_crawler',
            'description'
        );
        $sql = "INSERT IGNORE INTO `movies` (
                `name`,
                `slug`,
                `image`,
                `episodes`,
                `description`
             ) VALUES ";
        
        $values = array();
        foreach ($result as $v) {
            $values[] = "('{$v['name']}', '{$v['slug']}', '{$v['image']}', '{$v['episodes']}', '{$v['description']}')";
        }
        $sql .= implode(',', $values);
        $dup = array();
        foreach ($elements as $e) {
            $dup[] = "`{$e}` = VALUES({$e})";
        }
        $sql .= " ON DUPLICATE KEY UPDATE " . implode(',', $dup);
        $connection = ConnectionManager::get('default');
        $connection->execute($sql);
        
//        echo '<pre>';
//        print_r($result);
        die();
    }
    
    public function crawlerepisodes() {
        $result = array();
        $errors = array();
        $connection = ConnectionManager::get('default');
        $sql = "SELECT * FROM movies limit 5";
        $data = $connection->execute($sql)->fetchAll('assoc');
        foreach ($data as $v) {
            $episodes = json_decode($v['episodes'], true);
            foreach ($episodes as $ep) {
                $tmp = array(
                    'name' => $ep['name'],
                    'movie_id' => $v['id'],
                    'slug' => $this->convertURL($ep['name'])
                );
                // Get website content
                $str = file_get_contents($ep['link']);
                // Gets Webpage Internal Links
                $doc = new \DOMDocument;
                @$doc->loadHTML($str);
                $contentNode = $doc->getElementById("menu6");
                if (!empty($contentNode)) {
                    try {
                        $videoIframes = $this->getElementsByClass($contentNode, 'div', 'videoiframe');
                        foreach ($videoIframes as $vi) {
                            $servers = array();
                            $attr = $vi->getAttribute('data-id');
                            if ($attr == 'opcion1') {
                                $streams = $this->getElementsByClass($vi, 'div', 'open-stream-player');
                                if (!empty($streams)) {
                                    $servers[] = $streams[0]->getAttribute('id');
                                }
                            }
                        }
                        $tmp['servers'] = implode("\n", $servers);
                        $result[] = $tmp;
                    } catch (\Exception $ex) {
                        $errors[] = array(
                            'data' => $tmp,
                            'error' => $ex
                        );
                    }
                }
                
            }
        }
        
        // Insert data
        $elements = array(
            'name',
            'slug',
            'movie_id',
            'servers'
        );
        $sql = "INSERT IGNORE INTO `episodes` (
                `name`,
                `slug`,
                `movie_id`,
                `servers`
             ) VALUES ";
        
        $values = array();
        foreach ($result as $v) {
            $values[] = "('{$v['name']}', '{$v['slug']}', '{$v['movie_id']}', '{$v['servers']}')";
        }
        $sql .= implode(',', $values);
        $dup = array();
        foreach ($elements as $e) {
            $dup[] = "`{$e}` = VALUES({$e})";
        }
        $sql .= " ON DUPLICATE KEY UPDATE " . implode(',', $dup);
        $connection = ConnectionManager::get('default');
        $connection->execute($sql);
        
        echo '<pre>';
        print_r($result);
        die();
    }
    
    public function getElementsByClass(&$parentNode, $tagName, $className) {
        $nodes = array();
        try {
            $childNodeList = $parentNode->getElementsByTagName($tagName);
            for ($i = 0; $i < $childNodeList->length; $i++) {
                $temp = $childNodeList->item($i);
                if (stripos($temp->getAttribute('class'), $className) !== false) {
                    $nodes[]=$temp;
                }
            }
        } catch (Exception $ex) {

        }
        return $nodes;
    }
}