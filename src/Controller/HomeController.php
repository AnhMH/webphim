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
        $countries = TableRegistry::get('Countries')->find()->toList();
        $movies = TableRegistry::get('Movies')->find()->toList();
        $this->set(compact(array(
            'countries',
            'movies'
        )));
    }
}