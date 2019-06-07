<?php

namespace App\Controller;

class HomeController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow();
    }
    
    public function index()
    {
        
    }
}