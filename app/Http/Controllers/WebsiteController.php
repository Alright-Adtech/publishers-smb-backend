<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebsitePutRequest;
use App\Services\WebsiteService;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
  protected WebsiteService $service;

  public function __construct(WebsiteService $service)
  {
    $this->service = $service;
  }

  /**
   * @OA\Post(
   *  path="/api/websites",
   *  summary="Criar novo website para usuário logado.",
   *  security={{"bearerAuth":{}}},
   *  tags={"Websites"},
   *  @OA\RequestBody(
   *   required=true,
   *   @OA\MediaType(
   *    mediaType="application/json",
   *    @OA\Schema(
   *     @OA\Property(property="url", type="string", description="URL do website."),
   *    )
   *   )
   *  ),
   *  @OA\Response(
   *   response="200", description="Sucesso"
   *  ),
   * )
   */
  public function new(Request $request)
  {
    $request->validate([
      'url' => 'required|string|unique:websites|max:255',
    ]);

    $data = $request->only(['url']);
    $data['user_id'] = $request->user()->id;
    $website = $this->service->createWebsite($data);

    return $this->success([
      'website' => $website,
    ]);
  }

  /**
   * @OA\Put(
   *  path="/api/websites/{id}",
   *  summary="Altera os dados do usuário.",
   *  security={{"bearerAuth":{}}},
   *  tags={"Websites"},
   *  @OA\PathParameter(
   *   name="id",
   *   description="ID do website",
   *   required=true
   *  ),
   *  @OA\RequestBody(
   *   required=true,
   *   @OA\MediaType(
   *    mediaType="application/json",
   *    @OA\Schema(
   *     @OA\Property(property="state", type="string", description="Estado de atuação."),
   *     @OA\Property(property="city", type="string", description="Principal cidade de atuação."),
   *     @OA\Property(property="views", type="integer", description="Quantidade máxima de audiência do website."),
   *     @OA\Property(property="website_segment_id", type="integer", description="Segmento do website."),
   *    )
   *   )
   *  ),
   *  @OA\Response(
   *   response="200", description="Sucesso"
   *  ),
   *  @OA\Response(
   *   response="403", description="Usuário não tem permissões de alterar website."
   *  ),
   * )
   */
  public function set(WebsitePutRequest $request, int $websiteId)
  {
    $user = $request->user();
    if ($this->service->checkWithWebsiteIsTheUser($user, $websiteId)) {
      return $this->error('O usuário logado não pode alterar os dados do website', 403);
    }

    $data = $request->only([
      'state',
      'city',
      'views',
      'website_segment_id',
    ]);
    $website = $this->service->updateWebsite($data, $websiteId);

    return $this->success([
      'website' => $website,
    ]);
  }
}
