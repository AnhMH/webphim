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
            $sqlEpisodes = "SELECT * FROM episodes WHERE movie_id = {$data['id']} ORDER BY id ASC";
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
        ini_set('memory_limit', -1);
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
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
        ini_set('memory_limit', -1);
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        $result = array();
        $baseUrl = 'http://www.danfra.com/';
        $crawlermovieIds = array();
        $connection = ConnectionManager::get('default');
        $sql = "SELECT * FROM crawler_movies where updated is null";
        $data = $connection->execute($sql)->fetchAll('assoc');
        if (!empty($data)) {
            foreach ($data as $v) {
                $crawlermovieIds[] = $v['id'];
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
            if (!empty($crawlermovieIds)) {
                $ids = implode(',', $crawlermovieIds);
                $time = time();
                $connection->execute("UPDATE crawler_movies SET updated = {$time} WHERE id IN ({$ids})");
            }
        }
//        echo '<pre>';
//        print_r($result);
        die();
    }
    
    public function crawlerepisodes() {
        ini_set('memory_limit', -1);
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        $errors = array();
        $connection = ConnectionManager::get('default');
        $sql = "SELECT * FROM movies";
        $data = $connection->execute($sql)->fetchAll('assoc');
        foreach ($data as $v) {
            $result = array();
            $episodes = json_decode($v['episodes'], true);
            foreach ($episodes as $ep) {
                $tmp = array(
                    'name' => $ep['name'],
                    'movie_id' => $v['id'],
                    'slug' => $this->convertURL($ep['name'])
                );
                $servers = $this->getepisodes($ep['link']);
                $tmp['servers'] = implode("\n", $servers);
                $result[] = $tmp;
            }
            $this->addepisodes($result);
        }
//        echo '<pre>';
//        print_r($result);
        die();
    }
    
    public function getNewEpisodes() {
        ini_set('memory_limit', -1);
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        $result = array();
        $data = array();
        $baseUrl = 'http://www.danfra.com/';
        $episodePre = 'Capítulo ';
        $connection = ConnectionManager::get('default');
        
        // Get website content
        $str = file_get_contents($baseUrl);
        // Gets Webpage Internal Links
        $doc = new \DOMDocument;
        @$doc->loadHTML($str);

        $contentNode = $doc->getElementById("wrapper");

        $items = $this->getElementsByClass($contentNode, 'div', 'category-content');
        if (!empty($items[0])) {
//            foreach ($items as $item) {
                $links = $items[4]->getElementsByTagName('a');
                if (!empty($links[0])) {
                    foreach ($links as $link) {
                        $tmp = array();
                        $name = $link->getElementsByTagName('h3');
                        if (!empty($name[0])) {
                            $tmp['link'] = $baseUrl.$link->getAttribute('href');
                            $tmp['name'] = $name[0]->textContent;
                            $result[] = $tmp;
                        }
                    }
                }
//            }
        }
        
        $episodeModel = TableRegistry::get('Episodes');
        if (!empty($result)) {
            foreach ($result as $v) {
                $name = explode(" 1x", $v['name']);
                $movieSlug = $this->convertURL($name[0]);
                $episodeName = $episodePre.$name[1];
                $movie = $connection->execute("SELECT * FROM movies where slug = '{$movieSlug}' LIMIT 1")->fetchAll('assoc');
                if (!empty($movie[0])) {
                    $episode = $episodeModel->find()->where(['name' => $episodeName, 'movie_id' => $movie[0]['id']])->toArray();
                    if (empty($episode)) {
                        $tmp = array(
                            'name' => $episodeName,
                            'movie_id' => $movie[0]['id'],
                            'slug' => $this->convertURL($episodeName)
                        );
                        $servers = $this->getepisodes($v['link']);
                        $tmp['servers'] = implode("\n", $servers);
                        $data[] = $tmp;
                    }
                }
            }
            if (!empty($data)) {
                $this->addepisodes($data);
            }
        }
        
        echo '<pre>';
        print_r($data);
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
    
    public function addepisodes($result) {
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
        $movieData = array();
        foreach ($result as $v) {
            $movieData[] = array(
                'id' => $v['movie_id'],
                'last_episode' => $v['name'],
                'updated' => time() + 1
            );
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
        $this->updateMovies($movieData);
        
        return true;
    }
    
    public function updateMovies($result) {
        // Insert data
        $elements = array(
            'id',
            'last_episode',
            'updated'
        );
        $sql = "INSERT IGNORE INTO `movies` (
                `id`,
                `last_episode`,
                `updated`
             ) VALUES ";

        $values = array();
        $movieData = array();
        foreach ($result as $v) {
            $values[] = "('{$v['id']}', '{$v['last_episode']}', '{$v['updated']}')";
        }
        $sql .= implode(',', $values);
        $dup = array();
        foreach ($elements as $e) {
            $dup[] = "`{$e}` = VALUES({$e})";
        }
        $sql .= " ON DUPLICATE KEY UPDATE " . implode(',', $dup);
        $connection = ConnectionManager::get('default');
        $connection->execute($sql);
        
        return true;
    }
    
    public function getepisodes($url) {
        $servers = array();
        // Get website content
        $str = file_get_contents($url);
        // Gets Webpage Internal Links
        $doc = new \DOMDocument;
        @$doc->loadHTML($str);
        for ($i = 1; $i <= 10; $i++) {
            $contentNode = $doc->getElementById("menu{$i}");
            if (!empty($contentNode)) {
                try {
                    $videoIframes = $this->getElementsByClass($contentNode, 'div', 'videoiframe');
                    foreach ($videoIframes as $vi) {
                        $streams = array();
                        $attr = $vi->getAttribute('data-id');
                        if (strpos($attr, 'opcion') !== false) {
                            $streams = $this->getElementsByClass($vi, 'div', 'open-stream-player');
                            if (!empty($streams[0])) {
                                $servers[] = $streams[0]->getAttribute('id');
                            } else {
                                $streams = $vi->getElementsByTagName('iframe');
                                if (!empty($streams[0])) {
                                    $servers[] = $streams[0]->getAttribute('src');
                                }
                            }
                        } elseif (strpos($attr, 'parte') !== false) {
                            $streams = $vi->getElementsByTagName('iframe');
                            if (!empty($streams[0])) {
                                $servers[] = $streams[0]->getAttribute('src');
                            }
                        }
                    }
                } catch (\Exception $ex) {
                    $errors[] = array(
                        'data' => $url,
                        'error' => $ex
                    );
                }
            }
        }
        return $servers;
    }
}