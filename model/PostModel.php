<?php

namespace model;

use core\DBDriver;
use core\Validator;

class PostModel extends BaseModel
{
	protected $validator;
	protected $schema = [
		'id' => [
			'primary' => true
		],

		'name' => [
			'type' => 'string',
			'length' => [1, 50],
			'unique' => true,
			'not_blank' => true,
			'primary' => true
		],

		'content' => [
			'type' => 'string',
			'length' => 'text',
			'not_blank' => true,
			'require' => true
		],

		'data' => [
			'current_time' => true
		]
	];

	public function __construct(DBDriver $db, Validator $validator)
	{
		parent::__construct($db, $validator, 'articles');
		$this->validator->setRules($this->schema);
	}
}