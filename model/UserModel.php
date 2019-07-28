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

  public function signIn(array $fields)
  {
    $this->validator->execute($fields);

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

  public function getByLogin($login)
  {
    $sql = sprintf('SELECT * FROM %s WHERE login = :login', $this->table);
    return $this->db->select($sql, ['login' => $login], DBDriver::FETCH_ONE);
  }

  public function getBySid($sid)
  {
    $sql = sprintf('SELECT users.id as id, login, password FROM sessions JOIN %s ON sessions.id_user = users.id WHERE sessions.sid = :sid', $this->table);

    return $this->db->select($sql, ['sid' => $sid], DBDriver::FETCH_ONE); 
  }
 
  public function getHash($password)
  {
    return hash('sha256', $password);
  }
}