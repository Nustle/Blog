<?php

namespace Blog\Models;

use Blog\Core\DBDriver;
use Blog\Core\Validator;
use Blog\Core\Exception\ValidatorException;

abstract class BaseModel
{
	/**
	 * @var DBDriver
	 */
	protected $db;
	/**
	 * @var string
	 */
	protected $table;
	/**
	 * @var Validator
	 */
	protected $validator;

	public function __construct(DBDriver $db, Validator $validator, $table)
	{
		$this->db = $db;
		$this->validator = $validator;
		$this->table = $table;
	}
	
	public function getAll()
	{
		$sql = sprintf('SELECT * FROM %s ORDER BY data DESC', $this->table);
		return $this->db->select($sql);
	}

	public function getById($id)
	{
		$sql = sprintf('SELECT * FROM %s WHERE id = :id', $this->table);
		return $this->db->select($sql, ['id' => $id], DBDriver::FETCH_ONE);
	}

	public function getByName($name)
	{
		$sql = sprintf('SELECT * FROM %s WHERE name = :name', $this->table);
		return $this->db->select($sql, ['name' => $name], DBDriver::FETCH_ONE);
	}

	public function add(array $params)
	{
		$this->validator->execute($params);
			
		if (!$this->validator->success) {
			throw new ValidatorException($this->validator->errors);
		}

		$params = $this->validator->clean;
		
		return $this->db->insert($this->table, $params);
	}

	public function edit(array $params, $where)
	{
		$this->validator->execute($params);

		if (!$this->validator->success) {
			throw new ValidatorException($this->validator->errors);
		}

		$params = $this->validator->clean;

		return $this->db->update($this->table, $params, $where);
	}

	public function delete(array $where)
	{
		if (!$this->validator->success) {
			throw new ValidatorException($this->validator->errors);
		}

		return $this->db->delete($this->table, $where);
	}
}