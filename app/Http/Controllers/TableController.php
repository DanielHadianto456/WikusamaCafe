<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tableModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{

    //Function used to get all data from table 
    public function getMeja()
    {

        $data = tableModel::all();
        return response()->json($data);

    }

    //Function used to get data based on primary key
    public function getMejaId($id)
    {

        $data = tableModel::find($id);
        return response()->json($data);

    }

    //Function used to create table data
    public function addMeja(Request $request)
    {

        //Gets current user
        $Auth = Auth::user();

        //Check if current user's role is admin
        if ($Auth->role == "ADMIN") {

            //Validates input data
            $validator = Validator::make($request->all(), [
                'nomor_meja' => 'required|Integer',
            ]);

            //checks if validator fails
            if ($validator->fails()) {

                //Returns an error if so
                return response()->json($validator->errors()->toJson());

            }

            //Creates a variable used to save inputted data
            $save = tableModel::create([
                'nomor_meja' => $request->get('nomor_meja'),
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

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);

        }

    }

    //Function used to update table data
    public function updateMeja(Request $request, $id)
    {

        //Gets current user
        $Auth = Auth::user();

        //Check if current user's role is admin
        if ($Auth->role == "ADMIN") {

            //Validates input data for registration
            $validator = Validator::make($request->all(), [
                'nomor_meja' => 'required|Integer',
            ]);

            //Checks if validator fails
            if ($validator->fails()) {
                //Returns an error if so
                return response()->json($validator->errors()->toJson());
            }

            //Creates a variable to save inputted data
            $save = tableModel::where('id_meja', $id)->update([
                'nomor_meja' => $request->get('nomor_meja'),
            ]);

            //Checks if save is successful
            if ($save) {
                // If the $save is successful, return a 200 response
                // with a success message
                return response()->json(['status' => true, 'message' => 'Sukses mengubah'], status: 200);
            } else {
                // If the $save is not successful, return a 500 response
                // with an error message
                return response()->json(['status' => false, 'message' => 'Gagal mengubah'], status: 500);
            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);

        }

    }

    //Function used to delete table data

    public function deleteMeja($id)
    {

        //Gets current user
        $Auth = Auth::user();

        if ($Auth->role == "ADMIN") {

            //Deletes table data based on primary key
            $delete = tableModel::where('id_meja', $id)->delete();
            return response()->json($delete);

        } else {
            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menambah'], status: 500);
        }

    }

}
