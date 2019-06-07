<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
    
//    public function validationDefault(Validator $validator)
//    {
//        $validator
//            ->allowEmptyString('account', false)
//            ->allowEmptyString('name', false)
//            ->allowEmptyString('password', false)
//            ->minLength('password', 6)
//            ->maxLength('password', 255);
//
//        return $validator;
//    }
}