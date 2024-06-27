<?php

namespace App\Services;

use Exception;
use App\Enums\StatusSlugEnum;
use App\Models\User;
use App\Repositories\HistoryRepository;
use App\Repositories\StatusRepository;
use App\Repositories\WebsiteRepository;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class WebsiteService extends Service
{
  protected WebsiteRepository $repository;
  protected StatusRepository $statusRepository;
  protected HistoryRepository $historyRepository;


  public function __construct(WebsiteRepository $repository, StatusRepository $statusRepository, HistoryRepository $historyRepository)
  {
    $this->repository = $repository;
    $this->statusRepository = $statusRepository;
    $this->historyRepository = $historyRepository;
  }

  public function getById(int $id)
  {
    return $this->repository->getById($id);
  }

  public function createWebsite($data)
  {
    try {
      DB::beginTransaction();

      $status = $this->statusRepository->getBySlug(StatusSlugEnum::Started);
      $website = $this->repository->create($data);
      $this->historyRepository->create([
        'website_id' => $website->id,
        'status_id' => $status->id,
      ]);

      DB::commit();
    } catch (Exception $exception) {
      DB::rollBack();
      throw new InvalidArgumentException($exception->getMessage());
    }

    return $website
      ->load('histories')
      ->load('histories.status');
  }

  public function updateWebsite($data, $id)
  {
    try {
      DB::beginTransaction();
      $user = $this->repository->update($data, $id);
      DB::commit();
    } catch (Exception $exception) {
      DB::rollBack();
      throw new InvalidArgumentException($exception->getMessage());
    }

    return $user;
  }

  public function checkWithWebsiteIsTheUser(User $user, $websiteId): bool
  {
    $website = $this->getById($websiteId);
    return $website->user_id != $user->id;
  }
}
