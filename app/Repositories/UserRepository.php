<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{

  public function __construct(User $model)
  {
    parent::__construct($model);
  }

  public function getById($id)
  {
    return $this->model
      ->where('id', $id)
      ->with('websites')
      ->firstOrFail();
  }

  public function update(array $data, int $id)
  {
    $user = $this->model->find($id);

    if (array_key_exists('name', $data)) $user->name = $data['name'];
    if (array_key_exists('phone', $data)) $user->phone = $data['phone'];
    if (array_key_exists('signed_terms_of_use', $data)) $user->signed_terms_of_use = $data['signed_terms_of_use'];
    if (array_key_exists('user_segment_id', $data)) $user->user_segment_id = $data['user_segment_id'];
    $user->update();

    return $user;
  }
}
