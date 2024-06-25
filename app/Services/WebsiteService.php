<?php

namespace App\Services;

use App\Repositories\WebsiteRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class WebsiteService extends Service
{
  protected WebsiteRepository $repository;

  public function __construct(WebsiteRepository $repository)
  {
    $this->repository = $repository;
  }

  public function getById(int $id)
  {
    return $this->repository->getById($id);
  }

  public function createWebsite($data)
  {
    try {
      DB::beginTransaction();
      $website = $this->repository->create($data);
      DB::commit();
    } catch(Exception $exception) {
      DB::rollBack();
      throw new InvalidArgumentException($exception->getMessage());
    }

    return $website;
  }

  public function updateWebsite($data, $id)
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
