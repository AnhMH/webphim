<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class HomeController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow();
    }
    
    public function index()
    {
        $movies = TableRegistry::get('Movies')->find()->orderDesc('id')->toList();
        $this->set(compact(array(
            'movies'
        )));
    }
}