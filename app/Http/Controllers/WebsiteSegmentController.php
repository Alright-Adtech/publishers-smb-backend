<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\WebsiteSegmentService;

class WebsiteSegmentController extends Controller
{
  protected WebsiteSegmentService $service;

  public function __construct(WebsiteSegmentService $service)
  {
    $this->service = $service;
  }

  public function index()
  {
    $websiteSegments = $this->service->getAll();
    return $this->success([
      'websiteSegments' => $websiteSegments,
    ]);
  }
}
