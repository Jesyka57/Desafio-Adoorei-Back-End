<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @QA\Server(url="http://localhost/api"),
 * @OA\Info(title="Docker Example", version="0.0.0.1"),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
