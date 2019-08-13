<?php

namespace Blog\Models;

use Blog\Core\DBDriver;
use Blog\Core\Validator;

class PostModel extends BaseModel
{
	protected $schema = [
		'id' => [
			'primary' => true
		],

		'name' => [
			'type' => Validator::STRING,
			'length' => [1, 50],
			'not_blank' => true,
			'require' => true
		],

		'content' => [
			'type' => Validator::STRING,
			'length' => Validator::TEXT,
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