<?php

namespace App\Repositories;

use App\Models\History;

class HistoryRepository extends Repository
{
  public function __construct(History $model)
  {
    parent::__construct($model);
  }

  public function create(array $data)
  {
    $history = new $this->model;

    $history->website_id = $data['website_id'];
    $history->status_id = $data['status_id'];
    $history->save();

    return $history->fresh();
  }
}
