<?php

namespace App\Repositories;

use App\Models\UserSegment;

class UserSegmentsRepository
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
