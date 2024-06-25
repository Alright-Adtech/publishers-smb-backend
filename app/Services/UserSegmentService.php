<?php

namespace App\Services;

use App\Repositories\UserSegmentsRepository;

class UserSegmentService extends Service
{
  protected UserSegmentsRepository $repository;

  public function __construct(UserSegmentsRepository $repository)
  {
    $this->repository = $repository;
  }

  public function getAll()
  {
    return $this->repository->getAll();
  }
}
