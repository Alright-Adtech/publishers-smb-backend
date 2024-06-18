<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Laravel\Passport\Http\Middleware\CheckClientCredentials as MiddlewareCheckClientCredentials;

class CheckClientCredentials extends MiddlewareCheckClientCredentials
{
  public function handle($request, Closure $next, ...$scopes)  {
    $tokenIsNotInTheHeader = !$request->header('Authorization');
    if ($tokenIsNotInTheHeader) {
      $authorization = $request->cookie('Authorization');
      if ($authorization) {
        $tokenByCookie = Crypt::decryptString($authorization);
        $posForSlipt = strpos($tokenByCookie, '|') + 1;
        $tokenByCookie = substr($tokenByCookie, $posForSlipt - strlen($tokenByCookie));
  

        if ($tokenByCookie) {
          echo "GRITAAA\n";
          echo 'Bearer ' . $tokenByCookie;
          // $response = $next($request);
          // $response->headers->set('Authorization', 'Bearer ' . $tokenByCookie, true);
          // return $response;
         $request->headers->set('Authorization', 'Bearer ' . $tokenByCookie, true);
        }
      }
    }

    return parent::handle($request, $next, ...$scopes);
  }
}
