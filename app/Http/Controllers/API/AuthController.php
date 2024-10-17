<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userModel;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // In your Register function in AuthController
    public function Register(Request $request)
    {

        // Check if username already exists
        if (userModel::where('username', $request->username)->exists()) {
         
            return response()->json(['status' => false, 'message' => 'Username already taken'], 422);
        
        }

        // Other validation rules
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:100',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors()->toJson(), 400);
        
        }

        // Save user
        $save = userModel::create([
            'nama_user' => $request->get('nama_user'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'role' => $request->get('role'),
        ]);

        if ($save) {

            return response()->json(['status' => true, 'message' => 'User successfully registered'], 200);
        
        }

        return response()->json(['status' => false, 'message' => 'Failed to register user'], 500);
    
    }


    //Login Function
    public function Login(Request $request)
    {

        // Gets the username and password from the request
        $credentials = $request->only('username', 'password');

        try {
            // Attempt to authenticate the user using the default guard
            if (!$token = Auth::guard('user_model')->attempt($credentials)) {
                // If the authentication is not successful, return a 401 response
                // with an error message
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // If there is an error when creating the token, return a 500 response
            // with an error message
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // If the authentication is successful, return a response with the token, username, and role\
        $user = Auth::guard('user_model')->user();

        return response()->json([
            'user' => $request->username,
            'role' => $user->role,
            'token' => $token,
        ]);

    }

    //Logout Function
    public function Logout()
    {

        try {
            // Get the current authenticated user token to invalidate to prevent further uses after logout.
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        } catch (JWTException $e) {
            // Catch any errors during token invalidation process
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

    }


}
