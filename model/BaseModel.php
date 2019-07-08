<?php

namespace model;

use core\DBDriver;
use core\Validator;
use core\Exception\ModelException;

abstract class BaseModel
{
	protected $db;
	protected $table;
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
		$sql = sprintf('SELECT name FROM %s WHERE name = :name', $this->table);
		return $this->db->select($sql, ['name' => $name], DBDriver::FETCH_ONE);
	}

	public function add(array $params, $needValidation = true)
	{
		if ($needValidation) {
			$this->validator->execute($params);
			
			if (!$this->validator->success) {
				throw new ModelException($this->validator->errors);
				$this->validator->errors;
			}
			$params = $this->validator->clean;
		}
		return $this->db->insert($this->table, $params);
	}

	public function edit(array $params, array $where)
	{
		$this->validator->execute($params);

		if (!$this->validator->success) {
			throw new ModelException($this->validator->errors);
			$this->validator->errors;
		}

		return $this->db->update($this->table, $params, $where);
	}

	public function delete(array $where)
	{
		if (!$this->validator->success) {
			throw new ModelException($this->validator->errors);
			$this->validator->errors;
		}

		return $this->db->delete($this->table, $where);
	}
}