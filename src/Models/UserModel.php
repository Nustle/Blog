<?php

namespace Blog\Models;

use Blog\Core\DBDriver;
use Blog\Core\Validator;
use Blog\Core\Exception\ValidatorException;

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
      throw new ValidatorException($this->validator->errors);
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
    $sql = 'SELECT 
              users.id,
              users.login,
              users.password,
              sessions.sid
				    FROM users
				    JOIN sessions
					    ON users.id = sessions.id_user 
				    WHERE sessions.sid = :sid';

    return $this->db->select($sql, ['sid' => $sid], DBDriver::FETCH_ONE); 
  }
 
  public function getHash($password)
  {
    return hash('sha256', $password);
  }
}