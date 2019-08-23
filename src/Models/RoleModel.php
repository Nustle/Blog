<?php

namespace Blog\Models;

use Blog\Core\DBDriver;
use Blog\Core\Validator;

class RoleModel extends BaseModel
{
  protected $schema = [
    'id' => [
      'primary' => true
    ],

    'id_user' => [
      'type' => Validator::INTEGER,
      'require' => true
    ],

    'name' => [
      'type' => Validator::STRING,
      'length' => [5, 35],
      'not_blank' => true,
      'require' => true
    ],

    'description' => [
      'type' => Validator::STRING,
      'length' => 255
    ]
  ];

  public function __construct(DBDriver $db, Validator $validator)
  {
    parent::__construct($db, $validator, 'roles');
    $this->validator->setRules($this->schema);
  }

  public function checkPriv(string $priv, int $idUser)
  {
    $sql = 'SELECT
					roles.id_user AS id_user,
					roles.name AS role_name,
					privs.name AS priv_name
					FROM privs 
				JOIN accesses
					ON accesses.id_privs = privs.id
				JOIN roles
					ON roles.id = accesses.id_roles
				WHERE privs.name = :name AND roles.id_user = :id_user';

    return $this->db->select($sql, ['name' => $priv, 'id_user' => $idUser], DBDriver::FETCH_ONE);
  }
}
