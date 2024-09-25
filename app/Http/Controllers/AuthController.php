<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $userValidate = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "password" => ["required", 'confirmed'],
        ]);

        if ($userValidate->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Type failure",
                "error" => $userValidate->errors()->all(),

            ], 401);
        } else {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => $request->password,
            ]);

            return response()->json([
                "status" => true,
                "message" => "Successfully resgistered...!",
                "user" => $user
            ], 200);

        }
    }
    public function login(Request $request)
    {
        $userValidate = Validator::make($request->all(), [
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);
        if ($userValidate->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Type Error",
                'error' => $userValidate->errors()->all(),
            ], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                "status" => true,
                "message" => "Login successful",
                "user" => $user,
                "token" => $token,
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "credentail not Match",
            ], 401);

        }
    }

    public function logout(Request $request)
    {
        if ($request->user()) {

            $token = $request->user()->currentAccessToken();

            if ($token) {
                $token->delete();
            }

            Auth::logout();
        }

        return response()->json([
            "status" => true,
            "message" => "Logged out successfully!",
        ], 200);
    }
}
