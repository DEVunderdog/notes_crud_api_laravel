<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create($name, $email, $password){
        
        return User::create([
            "name" => $name,
            "email" => $email,
            "password" => bcrypt($password)
        ]);
    }

    public function login($email, $password){

        $user = User::where("email", $email)->first();

        if (!empty($user)){
            if(Hash::check($password, $user->password)){
                $token = $user->createToken("mytoken")->accessToken;
                return [
                    "status" => true,
                    "message" => "Login Successfull",
                    "token" => $token,
                    "data" => []
                ];
            } else {
                return [
                    "status" => false,
                    "message" => "incorrect password",
                    "data" => []
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => "Invalid Email Value",
                "data" => []
            ];
        }
    }

    public function profile($userData, $id){
        
        return [
            "status" => true,
            "message" => "Profile Information",
            "data" => $userData,
            "id" => $id
        ];
    }

    public function logout($token){
        
        $token->revoke();

        return [
            "status" => true,
            "message" => "User logged successfully"
        ];
    }
}
