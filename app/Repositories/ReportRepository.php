<?php

namespace App\Repositories;

use App\Models\Report;

class ReportRepository extends Repository
{
  public function __construct(Report $model)
  {
    parent::__construct($model);
  }

  public function getByWebsiteIdAndWithLimit(int $websiteId, int $limit)
  {
    return $this->model
      ->where('website_id', $websiteId)
      ->orderBy('date', 'desc')
      ->limit($limit)
      ->get();
  }
}
