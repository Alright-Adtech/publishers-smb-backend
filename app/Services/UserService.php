<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class UserService extends Service
{
  protected UserRepository $repository;

  public function __construct(UserRepository $repository)
  {
    $this->repository = $repository;
  }

  public function updateUser($data, $id)
  {
    try {
      DB::beginTransaction();
      $user = $this->repository->update($data, $id);
      DB::commit();
    } catch(Exception $exception) {
      DB::rollBack();
      throw new InvalidArgumentException($exception->getMessage());
    }

    return $user;
  }
}
