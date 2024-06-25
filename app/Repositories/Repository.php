<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;


class Repository
{
  protected Model $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function getAll()
  {
    return $this->model->get();
  }

  public function getById($id)
  {
    return $this->model
      ->where('id', $id)
      ->firstOrFail();
  }
}
