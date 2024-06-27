<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Services\WebsiteService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  protected ReportService $service;
  protected WebsiteService $websiteService;


  public function __construct(ReportService $service, WebsiteService $websiteService)
  {
    $this->service = $service;
    $this->websiteService = $websiteService;
  }

  /**
   * @OA\Get(
   *  path="/api/websites/{website_id}/reports/{limit}",
   *  summary="Retorna todos os relatórios do website com limite.",
   *  security={{"bearerAuth":{}}},
   *  tags={"Relatórios"},
   *  @OA\PathParameter(
   *   name="website_id",
   *   description="ID do website",
   *   required=true
   *  ),
   *  @OA\PathParameter(
   *   name="limit",
   *   description="Quantidade limite de linhas.",
   *   required=true
   *  ),
   *  @OA\Response(
   *   response="200", description="Sucesso",  @OA\JsonContent(),
   *  ),
   * )
   */
  public function getByWebsiteAndWithLimit(Request $request, int $websiteId, int $limit)
  {
    $user = $request->user();
    if ($this->websiteService->checkWithWebsiteIsTheUser($user, $websiteId)) {
      return $this->error('O usuário não pode acessar os dados do website', 403);
    }

    $reports = $this->service->getByWebsiteIdAndWithLimit($websiteId, $limit);
    return $this->success([
      'reports' => $reports,
    ]);
  }


}
