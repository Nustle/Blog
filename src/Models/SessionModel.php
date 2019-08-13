<?php

namespace Blog\Models;

use Blog\Core\DBDriver;
use Blog\Core\Validator;

class SessionModel extends BaseModel
{
  protected $schema = [
    'id' => [
      'primary' => true
    ],

    'id_user' => [
      'type' => Validator::INTEGER,
      'require' => true
    ],

    'sid' => [
      'type' => Validator::STRING,
      'length' => [3, 10],
      'not_blank' => true,
      'require' => true
    ],

    'created_at' => [
			'type' => 'timestamp',
    ],

    'updated_at' => [
      'type' => 'timestamp',
    ]
  ];

  protected $sid;

  public function __construct(DBDriver $db, Validator $validator)
  {
    parent::__construct($db, $validator, 'sessions');
    $this->validator->setRules($this->schema);
  }

  public function getSid()
  {
    return $this->sid;
  }
}