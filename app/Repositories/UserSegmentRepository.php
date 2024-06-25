<?php

namespace App\Repositories;

use App\Models\UserSegment;

class UserSegmentRepository
{
  protected UserSegment $userSegment;

  public function __construct(UserSegment $userSegment)
  {
    $this->userSegment = $userSegment;
  }

  public function getAll() {
    return $this->userSegment->get();
  }
}
