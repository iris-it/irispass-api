<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Irisit\IrispassShared\Model\User;
use Irisit\IrispassShared\Model\UserGroup;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function getCurrentUser(Request $request)
    {

        JWT::$leeway = 1000;

        $payload = JWT::decode($request->bearerToken(), config('jwt.keys.public'), array('RS256'));
        
        $data = [
            'sub' => $payload->sub,
            'name' => $payload->name,
            'preferred_username' => $payload->preferred_username,
            'given_name' => $payload->given_name,
            'family_name' => $payload->family_name,
            'email' => $payload->email,
            'resource_access' => json_encode($payload->resource_access->{env('OSJS_CLIENT_ID')}->roles),
        ];

        $user = User::where('sub', $payload->sub)->first();

        if (!$user) {
            $this->response->errorUnauthorized('Aucun compte n\'est trouvé');
        }

        $user->update($data);

        $user->provider()->update(['access_token' => $request->bearerToken()]);

        $user = JWTAuth::parseToken()->authenticate();

        return $this->response->array($user->toArray());

    }

    public function updateSettings(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $user->settings = $request->get('settings');

        $user->save();

        return $user->settings;
    }

    public function getUserGroups()
    {
        $groups = [];

        $user = JWTAuth::parseToken()->authenticate();

        $pivot = DB::table('groups_users_pivot')->where('user_id', $user->id)->get();

        foreach ($pivot as $group) {
            $groups[] = UserGroup::findOrFail($group->group_id)->toArray();
        }
        
        return $this->response->array($groups);

    }


}
