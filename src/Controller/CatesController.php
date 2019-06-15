<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;


class CatesController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow();
    }
    
    public function detail($slug = '')
    {
        $cate = TableRegistry::get('Countries')->findBySlug($slug)->firstOrFail();
        if (!empty($cate)) {
            $movies = TableRegistry::get('Movies')->findByCountryId($cate['id'])->toList();
            $this->set(compact(array(
                'movies'
            )));
        }
    }
}