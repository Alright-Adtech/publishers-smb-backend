<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;
use App\Abstracts\DB;

class Repository implements RepositoryContract
{

    protected \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getInstance();
    }

    public function fetchAllByQuery(string $query, $bindParam = array()): mixed
    {
        $result = $this->pdo->prepare($query);
        foreach ($bindParam as $key => $value) {
            $result->bindValue(':' . $key, $value);
        }
        $result->execute();    
        return $result->fetchAll();
    }

    /**
     * @param string $query
     * @param $mode
     * @return array|null|object
     */
    public function fetchOneByQuery(string $query, $mode = \PDO::FETCH_ASSOC, $bindParam = array()): object|array|null
    {
        $result = $this->pdo->prepare($query);
        foreach ($bindParam as $key => $value) {
            $result->bindValue(':' . $key, $value);
        }
        $result->execute();
        return $result->rowCount() > 0 ?
            $result->fetch($mode) :
            (
                $mode === \PDO::FETCH_ASSOC ? [] : null
            );
    }

    public function insert($query, $bindParam)
  {
      $statement = $this->pdo->prepare($query);
      foreach ($bindParam as $key => $value) {
          $statement->bindValue(':' . $key, $value);
      }
      return $statement->execute();
  }

  public function execute(string $query, array $params = array()): bool
  {
      $result = $this->pdo->prepare($query);
      return $result->execute($params);
  }

    public function find(string $query, array $fields, array $searches, string $soundexField = '', array $binds = []): mixed
    {
        $sqlBase = ' AND (CONCAT(' . implode(",'$',", $fields) . ')';
        $replacement = '';

        foreach (array_keys($searches) as $key) {
            $replacement .= $sqlBase . '  LIKE :query' . $key . (strlen($soundexField) > 0 ? ' OR SOUNDEX(' . $soundexField . ') = SOUNDEX(:querySoundex' . $key . '))' : ')');
        }

        $statement = $this->pdo->prepare(
            str_replace("#SEARCH#", substr($replacement, 4), $query)
        );

        foreach ($binds as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        foreach ($searches as $key => $value) {
            $statement->bindValue(':query' . $key, "%{$value}%");
            if (strlen($soundexField) > 0) {
                $statement->bindValue(':querySoundex' . $key, $value);
            }
        }

        $statement->execute();
        return $statement->fetchAll();
    }

    public function findBy(string $query, array $wheres = []): array|false
    {
        $statement = $this->pdo->prepare($query);
        foreach ($wheres as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        $statement->execute();
        return $statement->fetchAll();
    }
}
