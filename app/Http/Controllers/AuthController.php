<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(CustomerRegisterRequest $request)
    {
        $data = $request->validated();

          $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender'=>$data['gender']
          ]);
          return response('User created', 200);

    }

    public function login(Request $request)
    {

          $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
          ]);

          if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Create sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response([
              'user' => $user,
              'token' => $token
            ]);

          } else {
            return response([
              'error' => 'Invalid credentials'
            ], 422);
          }

        }



}
