<?php

namespace core;

class DBDriver
{
  const FETCH_ALL = 'all';
  const FETCH_ONE = 'one';

  private $pdo;

  public function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function select($sql, array $params = [], $fetch = self::FETCH_ALL)
  {
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    if ($fetch === self::FETCH_ALL) {
      return $stmt->fetchAll();
    }
    else {
      return $stmt->fetch();
    }

    return null;
    //return $fetch === self::FETCH_ALL ? $stmt->fetchAll() : $stmt->fetch();
  }

  public function insert($table, array $params)
  {
    $columns = sprintf('(%s)', implode(', ', array_keys($params)));
    $masks = sprintf('(:%s)', implode(', :', array_keys($params)));

    $sql = sprintf('INSERT INTO %s %s VALUES %s', $table, $columns, $masks);

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $this->pdo->lastInsertId();
  }

  public function update($table, array $params, array $where)
  {
    $column = [];
    $param = [];

    foreach ($params as $k => $v) {
      $column[] = "$k = :$k";
    }

    foreach ($where as $k => $v) {
      $param[] = "$k = :$k";
    }

    $columns = sprintf('%s', implode(', ', $column));
    $condition = sprintf('%s', implode(', ', $param));
    $merge = array_merge($params, $where);

    $sql = sprintf('UPDATE %s SET %s WHERE %s', $table, $columns, $condition);

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($merge);

    return $this->pdo->lastInsertId();
  }

  public function delete($table, array $where)
  {
    $param = [];

    foreach ($where as $k => $v) {
      $param[] = "$k = :$k";
    }

    $condition = sprintf('%s', implode(', ', $param));

    $sql = sprintf('DELETE FROM %s WHERE %s', $table, $condition);

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($where);
    
    return true;
  }
}
