<?php

namespace App\Services;

use App\Repositories\UserSegmentRepository;

class UserSegmentService extends Service
{
  protected UserSegmentRepository $repository;

  public function __construct(UserSegmentRepository $repository)
  {
    $this->repository = $repository;
  }

  public function getAll()
  {
    return $this->repository->getAll();
  }
}
