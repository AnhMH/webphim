<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CountriesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
    
//    public function validationDefault(Validator $validator)
//    {
//        $validator
//            ->allowEmptyString('name', false);
//
//        return $validator;
//    }
}