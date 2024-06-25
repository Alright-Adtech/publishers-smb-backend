<?php

namespace App\Repositories;

use App\Models\Website;

class WebsiteRepository
{
  protected Website $website;

  public function __construct(Website $website)
  {
    $this->website = $website;
  }

  public function getById($id)
  {
    return $this->website
      ->where('id', $id)
      ->firstOrFail();
  }

  public function create(array $data)
  {
    $website = new $this->website;

    $website->url = $data['url'];
    $website->user_id = $data['user_id'];
    $website->save();

    return $website->fresh();
  }

  public function update(array $data, int $id)
  {
    $website = $this->website->find($id);

    if (array_key_exists('state', $data)) $website->state = $data['state'];
    if (array_key_exists('city', $data)) $website->city = $data['city'];
    if (array_key_exists('views', $data)) $website->views = $data['views'];
    if (array_key_exists('website_segment_id', $data)) $website->website_segment_id = $data['website_segment_id'];
    $website->update();

    return $website;
  }
}
