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
    //Register Function
    public function Register(Request $request)
    {

        //Validates input data for registration
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|String|max:100',
            'username' => 'required|String|max:100',
            'password' => 'required|String|max:100',
            'role' => 'required',
        ]);

        //Checks if validator fails
        if ($validator->fails()) {
            //Returns an error if so
            return response()->json($validator->errors()->toJson());
        }

        //Creates a variable to save inputted data
        $save = userModel::create([
            'nama_user' => $request->get('nama_user'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'role' => $request->get('role'),
        ]);

        //Checks if save is successful
        if ($save) {
            // If the $save is successful, return a 200 response
            // with a success message
            return response()->json(['status' => true, 'message' => 'Sukses menambah'], status: 200);
        } else {
            // If the $save is not successful, return a 500 response
            // with an error message
            return response()->json(['status' => false, 'message' => 'Gagal menambah'], status: 500);
        }

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

        // If the authentication is successful, return a response with the token and username
        return response()->json([
            'user' => $request->username,
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
