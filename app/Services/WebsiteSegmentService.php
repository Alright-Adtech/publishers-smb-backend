<?php

namespace App\Services;

use App\Repositories\WebsiteSegmentRepository;

class WebsiteSegmentService extends Service
{
  protected WebsiteSegmentRepository $repository;

  public function __construct(WebsiteSegmentRepository $repository)
  {
    $this->repository = $repository;
  }

  public function getAll()
  {
    return $this->repository->getAll();
  }
}
