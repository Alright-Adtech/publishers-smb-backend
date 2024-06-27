<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService extends Service
{
  protected ReportRepository $repository;

  public function __construct(ReportRepository $repository)
  {
    $this->repository = $repository;
  }

  public function getByWebsiteIdAndWithLimit(int $websiteId, int $limit = 7)
  {
    return $this->repository->getByWebsiteIdAndWithLimit($websiteId, $limit);
  }
}
