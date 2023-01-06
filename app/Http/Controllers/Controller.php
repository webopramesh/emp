<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   title="Register and login Api Documentation",
 *   version="1.0.0",
 * ),
 *   @OA\Server(
 *       url="/api",
 *   ),
 * @OA\SecurityScheme(
 *   securityScheme="Bearer_auth",
 *   type="http",
 *   scheme="bearer",
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
