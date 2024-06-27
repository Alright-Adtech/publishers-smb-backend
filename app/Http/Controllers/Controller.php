<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 * title="Publishers SMB",
 * version="1.0.0",
 * )
 * @OA\SecurityScheme(
 * type="http",
 * securityScheme="bearerAuth",
 * scheme="bearer",
 * bearerFormat="JWT"
 * )
 */
abstract class Controller
{
  protected function success(array $data)
  {
    return response()->json($data);
  }


  protected function error(String $message, Int $code)
  {
    return response()->json([
      'message' => $message,
    ], $code);
  }
}
