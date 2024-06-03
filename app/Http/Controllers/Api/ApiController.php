<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\EmailJob;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|confirmed"
        ]);

        $user = $this->userService->create(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        EmailJob::dispatch($request->email);

        return response()->json([
            "status" => true,
            "message" => "user registered successfully",
            "data" => $user
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);

        $response = $this->userService->login(
            $request->input('email'),
            $request->input('password')
        );

        return response()->json($response);
        
    }

    public function profile()
    {
        $userData = auth() -> user();
        $response = $this->userService->profile(
            $userData,
            $userData->id
        );

        return response()->json($response);
    }

    public function logout()
    {
        $token = auth()->user()->token();

        $response = $this->userService->logout(
            $token
        );

        return response()->json($response);
    }
}
