<?php

namespace App\Repositories;

use App\Models\UserSegment;

class UserSegmentRepository extends Repository
{
  public function __construct(UserSegment $model)
  {
    parent::__construct($model);
  }
}
