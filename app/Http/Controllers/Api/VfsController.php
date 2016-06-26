<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Irisit\IrispassShared\Model\User;
use Dingo\Api\Routing\Helpers;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class VfsController extends Controller
{
    
    public function handleRequests(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $method = $request->get('method');
        $args = $request->get('args');

        Log::debug("#####################################################################");
        Log::debug($user);
        Log::debug($method);
        Log::debug($args);
        Log::debug("#####################################################################");


        return 'ok';
    }


}
