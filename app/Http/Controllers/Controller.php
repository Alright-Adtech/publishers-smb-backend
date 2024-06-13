<?php

namespace App\Http\Controllers;

abstract class Controller
{
  protected function success(array $data)
  {
    return response()->json($data);
  }


  protected function error(String $message, Int $code)
  {
    return response(status: $code)->json([
      'message' => $message,
    ]);
  }
}
