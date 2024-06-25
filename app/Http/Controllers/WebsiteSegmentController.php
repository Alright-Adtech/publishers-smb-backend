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

  /**
   * @OA\Get(
   *  path="/api/website-segments",
   *  summary="Retorna todos os segmentos dos websites.",
   *  security={{"bearerAuth":{}}},
   *  tags={"Segmentos dos Websites"},
   *  @OA\Response(
   *   response="200", description="Success"
   *  ),
   * )
   */
  public function index()
  {
    $websiteSegments = $this->service->getAll();
    return $this->success([
      'websiteSegments' => $websiteSegments,
    ]);
  }
}
