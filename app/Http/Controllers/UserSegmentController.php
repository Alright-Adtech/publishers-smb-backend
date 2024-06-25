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

  /**
   * @OA\Get(
   *  path="/api/user-segments",
   *  summary="Retorna todos os segmentos dos usuários.",
   *  security={{"bearerAuth":{}}},
   *  tags={"Segmentos dos Usuários"},
   *  @OA\Response(
   *   response="200", description="Success"
   *  ),
   * )
   */
  public function index()
  {
    $userSegments = $this->service->getAll();
    return $this->success([
      'userSegments' => $userSegments,
    ]);
  }
}
