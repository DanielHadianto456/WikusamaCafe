<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{

    //Function used to get all user data
    public function getUserData()
    {

        //Gets current user
        $Auth = Auth::user();

        //Checks if current user's role is ADMIN
        if ($Auth->role == "ADMIN") {

            //Gets all user data
            // $data = userModel::all();
            $data = userModel::withTrashed()->get();
            return response()->json($data);

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Gagal, user bukan admin'], status: 500);

        }

    }

    //Function used to get user data based on primary key
    public function getUserDataId($id)
    {

        //Gets current user
        $Auth = Auth::user();

        //Checks if current user's role is ADMIN
        if ($Auth->role == "ADMIN") {

            //Gets all user data
            $data = userModel::find($id);
            return response()->json($data);

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Gagal, user bukan admin'], status: 500);

        }

    }

    //Function to update user data
    public function updateUserData(Request $request, $id)
    {

        // Gets current user
        $Auth = Auth::user();

        // Check if username already exists
        if (userModel::where('username', $request->username)->exists()) {
         
            return response()->json(['status' => false, 'message' => 'Username already taken'], 422);
        
        }

        // Creates a validator to validate inputs
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|String|max:100',
            'nama_user' => 'nullable|String|max:100',
            'role' => 'nullable|String',
        ]);

        // Checks if validator fails
        if ($validator->fails()) {

            // Returns an error if so
            return response()->json($validator->errors()->toJson());

        }

        // Check if the user is updating their own data
        if ($Auth->role == "ADMIN" && $Auth->id_user == $id) {

            // Initialize an array to hold the update data
            $updateData = [
                'username' => $request->get('username') ?? userModel::select('username')->find($id)->username,
                'nama_user' => $request->get('nama_user') ?? userModel::select('nama_user')->find($id)->nama_user,
                'role' => "ADMIN",
            ];

            //Update user data based on primary key
            $save = userModel::find($id)->update($updateData);

            if ($save) {

                return response()->json(['status' => true, 'message' => 'Sukses menghapus'], 200);

            } else {

                return response()->json(['status' => false, 'message' => 'Gagal memperbarui'], 500);

            }

        //If the user isn't updating their own data,
        //This else statement will check if the user is an admin
        } else if ($Auth->role == "ADMIN") {



            // Initialize an array to hold the update data
            $updateData = [
                'username' => $request->get('username') ?? userModel::select('username')->find($id)->username,
                'nama_user' => $request->get('nama_user') ?? userModel::select('nama_user')->find($id)->nama_user,
                'role' => $request->get('role') ?? userModel::select('role')->find($id)->role,
                // 'role' => "lol",
            ];

            //Update user data based on primary key
            $save = userModel::find($id)->update($updateData);

            if ($save) {

                return response()->json(['status' => true, 'message' => 'Sukses menghapus'], 200);

            } else {

                return response()->json(['status' => false, 'message' => 'Gagal memperbarui'], 500);

            }
            
        } else {

            // If the user is not an admin and trying to update someone else's data, return an error
            return response()->json(['error' => 'Unauthorized'], 403);

        }

        // Checks if the update is successful
        if ($update) {

            return response()->json(['success' => 'User data updated successfully']);

        } else {

            return response()->json(['error' => 'Failed to update user data'], 500);

        }

    }

    // Function used to delete a user based on primary key
    public function deleteUser($id)
    {
        // Gets current user
        $Auth = Auth::user();

        // Checks if user's role is ADMIN
        if ($Auth->role == "ADMIN") {

            // Check if the user to be deleted is the currently logged-in user
            if ($Auth->id_user == $id) {

                return response()->json(['status' => false, 'message' => 'Gagal, tidak bisa menghapus user yang sedang login'], 400);

            } else {

                // Deletes user data based on primary key
                $delete = userModel::find($id);
                $delete->delete();
                return response()->json(['status' => true, 'message' => 'User berhasil dihapus']);

            }
        } else {

            // Else returns an error
            return response()->json(['status' => false, 'message' => 'Gagal, user bukan admin'], 403);

        }

    }

}
