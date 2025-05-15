<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, UserRepository $userRepo)
    {
        $user = $userRepo->create($request->validated());

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => new UserResource($user),
        ], 201);
    }

    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }
}
