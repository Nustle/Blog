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
    $this->sid = $this->genSid();
  }

  public function set(string $sid, int $idUser)
  {
    $this->validator->execute(
      [
        'sid' => $sid,
        'id_user' => $idUser
      ]
  );

    if (!$this->validator->success) {
      throw new ValidationException($this->validator->errors);
    }

    return $this->add([
      'sid' => $this->validator->clean['sid'],
      'id_user' => $this->validator->clean['id_user']
    ]);
  }

  public function update(string $sid)
  {
    return $this->edit(
      ['updated_at' => date('Y-m-d H:i:s')],
      sprintf('sid="%s"', $sid)
    );
  }

  public function getSid()
  {
    return $this->sid;
  }

  protected function genSid()
  {
    $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_-#@%*&';
    $strlen = strlen($pattern) - 1;
    $sid = '';

    for ($i = 0; $i < 20; $i++) {
      $char = mt_rand(0, $strlen);
      $sid .= $pattern[$char];
    }

    return $sid;
  }
}