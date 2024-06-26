<?php

namespace App\Repositories;

use App\Enums\StatusSlugEnum;
use App\Models\Status;

class StatusRepository extends Repository
{
  public function __construct(Status $model)
  {
    parent::__construct($model);
  }

  public function getBySlug(StatusSlugEnum $slug)
  {
    return $this->model
      ->where('slug', $slug)
      ->firstOrFail();
  }
}
