<?php

namespace model;

use core\DBDriver;
use core\Validator;
use core\Exception\UserException;

class UserModel extends BaseModel
{
  protected $schema = [
    'id' => [
      'primary' => true
    ],

    'login' => [
      'type' => Validator::STRING,
      'length' => [3, 50],
      'not_blank' => true,
      'require' => true
    ],

    'password' => [
      'type' => Validator::STRING,
      'length' => [8, 50],
      'not_blank' => true,
      'require' => true
    ]
  ];

  public function __construct(DBDriver $db, Validator $validator)
  {
    parent::__construct($db, $validator, 'users');
    $this->validator->setRules($this->schema);
  }

  public function signUp(array $fields)
  {
    $this->validator->execute($fields);
    /*var_dump($this->validator->clean);
    exit();*/
    if (!$this->validator->success) {
      throw new UserException($this->validator->errors);
    }

    return $this->add(
      [
        'login' => $this->validator->clean['login'],
        'password' => $this->getHash($this->validator->clean['password'])
      ]
    );
  }
 
  public function getHash($password)
  {
    return hash('sha256', $password);
  }
}