<?php

namespace App\Repositories;

use App\Models\WebsiteSegment;

class WebsiteSegmentRepository
{
  protected WebsiteSegment $model;

  public function __construct(WebsiteSegment $model)
  {
    $this->model = $model;
  }

  public function getAll() {
    return $this->model->get();
  }
}
