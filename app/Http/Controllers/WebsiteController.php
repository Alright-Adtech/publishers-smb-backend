<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
  protected UserService $service;

  public function __construct(UserService $service)
  {
    $this->service = $service;
  }

  public function new(Request $request)
  {

  }

  public function set(Request $request, int $websiteId)
  {

  }
}
