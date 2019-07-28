<?php

namespace model;

use core\DBDriver;
use core\Validator;
use core\Exception\UserException;

class SessionModel extends BaseModel
{
  protected $schema = [
    'id' => [
      'primary' => true
    ],

    'sid' => [
      'type' => Validator::STRING,
      'length' => [3, 10],
      'not_blank' => true,
      'require' => true
    ]
  ];

  public function __construct(DBDriver $db, Validator $validator)
  {
    parent::__construct($db, $validator, 'sessions');
    $this->validator->setRules($this->schema);
  }

  public function getBySid($sid)
  {
    $sql = sprintf('SELECT sid FROM %s WHERE sid = :sid', $this->table);

    return $this->db->select($sql, ['sid' => $sid], DBDriver::FETCH_ONE);
  }
}