<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserFilesystemService;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class FileSystemController extends Controller
{

    public function handleRequests(Request $request, $mount, $method)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $user_id = JWT::decode($request->bearerToken(), config('jwt.keys.public'), array('RS256'))->sub;

        $data = [];

        if ($mount === 'home') {

            $filesystemService = new UserFilesystemService();

            $filesystemService->initialize($user, $user_id);

            $data = $filesystemService->call($method, $request);

        } else if ($mount === 'groups') {
            ///
        }

        return $this->response->array($data);

    }


}
