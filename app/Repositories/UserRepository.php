<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
  protected User $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getById($id)
  {
    return $this->user
      ->where('id', $id)
      ->with('websites')
      ->firstOrFail();
  }

  public function update(array $data, int $id)
  {
    $user = $this->user->find($id);

    if (array_key_exists('name', $data)) $user->name = $data['name'];
    if (array_key_exists('phone', $data)) $user->phone = $data['phone'];
    if (array_key_exists('signed_terms_of_use', $data)) $user->signed_terms_of_use = $data['signed_terms_of_use'];
    if (array_key_exists('user_segment_id', $data)) $user->user_segment_id = $data['user_segment_id'];
    $user->update();

    return $user;
  }
}
