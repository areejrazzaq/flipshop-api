<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $fields = ['email', 'password', 'name', 'role', 'password_confirmation'];
        $credentials = $request->only($fields);
        $validator = Validator::make(
            $credentials,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'role' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response($validator->messages());
        }

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);
        $user->assignRole($credentials['role']);

        $user['token'] = $this->tokenFromUser($user);

        return response($user->only(['email', 'token']));
    }

    
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $result['token'] = $this->tokenFromUser($user);
            $result['email'] = $user->email;
            $result['name'] = $user->name;
            $result['role'] = $user->roles->pluck('name')[0];

            return response($result);
        }
        return response(['message'=>'Invalid Credentials']);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function tokenFromUser(User $user)
    {
        Auth::shouldUse('api');
        // logs in the user
        Auth::guard('web')->loginUsingId($user->id);

        // get and return a new token
        $token = $user->createToken('Token Name')->accessToken;
        return $token;
    }
}
