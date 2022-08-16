<?php

namespace App\Http\Controllers;

use App\Http\Traits\GlobalTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthController extends Controller
{
    use GlobalTraits;
    // #########################################################################
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    // #########################################################################
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->SendResponse(null, $validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return $this->SendResponse(null, $validator->errors(), 401);
        }
        return $this->SendResponse($this->createNewToken($token), "Success Login", 200);
    }
    // #########################################################################
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->SendResponse(null, $validator->errors(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return $this->SendResponse($user, 'User successfully registered', 201);
    }
    // #########################################################################
    public function logout()
    {
        auth()->logout();
        return $this->SendResponse(auth()->user(), 'User successfully logout', 200);
    }
    // #########################################################################
    public function refresh()
    {
        return $this->SendResponse(Auth::guard('api')->refresh(), null, 200);
    }
    // #########################################################################
    public function userProfile()
    {
        // note send token with link
        return $this->SendResponse(auth()->user(), null, 200);
    }
    // #########################################################################
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    // #########################################################################
}
