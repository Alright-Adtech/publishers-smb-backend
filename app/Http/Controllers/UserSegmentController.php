<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserSegmentService;

class UserSegmentController extends Controller
{
  protected UserSegmentService $service;

  public function __construct(UserSegmentService $service)
  {
    $this->service = $service;
  }

  public function index()
  {
    $userSegments = $this->service->getAll();
    return $this->success([
      'userSegments' => $userSegments,
    ]);
  }
}
