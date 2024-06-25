<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPutRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
  protected UserService $service;

  public function __construct(UserService $service)
  {
    $this->service = $service;
  }

  /**
   * @OA\Get(
   *  path="/api/user",
   *  summary="Retorna os dados do usuário.",
   *  description="Retorna os dados do usuário incluindo todos os websites.",
   *  security={{"bearerAuth":{}}},
   *  tags={"Usuário"},
   *  @OA\Response(
   *   response="200", description="Sucesso"
   *  ),
   * )
   */
  public function get(Request $request)
  {
    $userId = $request->user()->id;
    $user = $this->service->getById($userId);

    return $this->success([
      'user' => $user,
    ]);
  }

  /**
   * @OA\Put(
   *  path="/api/user",
   *  summary="Altera os dados do usuário.",
   *  security={{"bearerAuth":{}}},
   *  tags={"Usuário"},
   *  @OA\RequestBody(
   *   required=true,
   *   @OA\MediaType(
   *    mediaType="application/json",
   *    @OA\Schema(
   *     @OA\Property(property="name", type="string", description="Nome do usuário"),
   *     @OA\Property(property="phone", type="string", description="Telefone do usuário"),
   *     @OA\Property(property="signed_terms_of_use", type="boolean", description="Termos de uso aceito pelo usuário."),
   *     @OA\Property(property="user_segment_id", type="integer", description="Segmento do usuário."),
   *    )
   *   )
   *  ),
   *  @OA\Response(
   *   response="200", description="Sucesso"
   *  ),
   * )
   */
  public function set(UserPutRequest $request)
  {
    $userId = $request->user()->id;
    $data = $request->only([
      'name',
      'phone',
      'signed_terms_of_use',
      'user_segment_id',
    ]);

    $user = $this->service->updateUser($data, $userId);

    return $this->success([
      'user' => $user,
    ]);
  }
}
