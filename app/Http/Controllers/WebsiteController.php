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

  public function set(WebsitePutRequest $request, int $websiteId)
  {
    $website = $this->service->getById($websiteId);
    $userId = $request->user()->id;

    $userCannotChangeWebsite = $website->user_id !== $userId;
    if ($userCannotChangeWebsite) {
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
