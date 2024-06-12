<?php

namespace App\Contracts;

interface RepositoryContract
{
  /**
   * Get all data method
   * 
   * @param string $query
   * 
   * @return mixed
   */
  public function fetchAllByQuery(string $query): mixed;

  /**
   * Find data method
   * 
   * @param string $query
   * @param array $fields
   * @param array $searches
   * @param string $soundexField
   * @param array $binds
   * 
   * @return mixed
   */
  public function find(string $query, array $fields, array $searches, string $soundexField = '', array $binds = []): mixed;
}