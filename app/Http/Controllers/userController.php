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
            $data = userModel::all();
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

    public function updateUserData(Request $request, $id)
    {

        //Gets current user
        $Auth = Auth::user();

        //Check if user's role is ADMIN
        if ($Auth->role == "ADMIN") {

            //Creates a validator to validate inputs
            $validator = Validator::make($request->all(), [
                'username' => 'required|String|max:100',
                'nama_user' => 'required|String|max:100',
                'role' => 'required|String',
            ]);

            //Checks if validator fails
            if ($validator->fails()) {
                //Returns an error if so
                return response()->json($validator->errors()->toJson());
            }

            //Creates a variable to store updated data
            $update = userModel::find($id)->update([
                'username' => $request->username,
                'nama_user' => $request->nama_user,
                'role' => $request->role,
            ]);

            //Checks if the update is successful
            if ($update) {

                //If the $save is successful, return a 200 response
                // with a success message
                return response()->json(['status' => true, 'message' => 'Berhasil Mengubah'], status: 200);

            } else {

                //else returns an error
                return response()->json(['status' => false, 'message' => 'Gagal mengubah'], status: 500);

            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Gagal, user bukan admin'], status: 500);

        }

    }   

    //Function used to delete a user based on primary key
    public function deleteUser($id){

        //Gets current user
        $Auth = Auth::user();

        //Checks if user's role is ADMIN
        if ($Auth->role == "ADMIN") {

            //Deletes user data based on primary key
            $delete = userModel::find($id)->delete();
            return response()->json($delete);

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Gagal, user bukan admin'], status: 500);

        }

    }
    

}
