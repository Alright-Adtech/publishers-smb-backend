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

  public function get(Request $request)
  {
    $userId = $request->user()->id;
    $user = $this->service->getById($userId);

    return $this->success([
      'user' => $user,
    ]);
  }

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
