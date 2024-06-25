<?php

namespace App\Repositories;

use App\Models\WebsiteSegment;

class WebsiteSegmentRepository extends Repository
{

  public function __construct(WebsiteSegment $model)
  {
    parent::__construct($model);
  }
}
