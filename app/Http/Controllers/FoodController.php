<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\foodModel;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    //Function to get data from menu table

    public function getFood()
    {

        //Gets all data from menu table
        $food = foodModel::all();
        return response()->json($food);

    }

    //Function to get data from menu table based on primary key
    public function getFoodId($id)
    {

        //Gets data from menu table based on primary key
        $food = foodModel::find($id);
        return response()->json($food);

    }

    //Function used to create food data
    public function addFood(Request $request)
    {

        //Gets current user
        $Auth = Auth::user();

        //Check if current user's role is admin
        if ($Auth->role == "ADMIN") {

            //Validates input data
            $validator = Validator::make($request->all(), [
                'nama_menu' => 'required|String|max:100',
                'jenis' => 'required',
                'deskripsi' => 'required|String',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'harga' => 'required|Integer',
            ]);

            //Checks if validator fails
            if ($validator->fails()) {
                //Returns an error if so
                return response()->json($validator->errors()->toJson());
            }

              // Handle image upload
              if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->storeAs('images/menu', $imageName, 'public');
            }



            //Creates a variable to save inputted data
            $save = foodModel::create([
                'nama_menu' => $request->get('nama_menu'),
                'jenis' => $request->get('jenis'),
                'deskripsi' => $request->get('deskripsi'),
                'gambar' => $imagePath,
                'harga' => $request->get('harga'),
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

    //Function used to update food data
    public function updateFood(Request $request, $id)
    {

        //Gets current user
        $Auth = Auth::user();

        //Check if current user's role is admin
        if ($Auth->role == "ADMIN") {

            //Validates input data for registration
            $validator = Validator::make($request->all(), [
                'nama_menu' => 'required|String|max:100',
                'jenis' => 'required',
                'deskripsi' => 'required|String',
                'harga' => 'required|Integer',
            ]);

            //Checks if validator fails
            if ($validator->fails()) {
                //Returns an error if so
                return response()->json($validator->errors()->toJson());
            }

            //Creates a variable to save inputted data
            $save = foodModel::where('id_menu', $id)->update([
                'nama_menu' => $request->get('nama_menu'),
                'jenis' => $request->get('jenis'),
                'deskripsi' => $request->get('deskripsi'),
                'harga' => $request->get('harga'),
            ]);

            //Checks if save is successful
            if ($save) {
                // If the $save is successful, return a 200 response
                // with a success message
                return response()->json(['status' => true, 'message' => 'Sukses memperbarui'], status: 200);
            } else {
                // If the $save is not successful, return a 500 response
                // with an error message
                return response()->json(['status' => false, 'message' => 'Gagal memperbarui'], status: 500);
            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa memperbarui'], status: 500);

        }

    }

    //Function used to delete food data

    public function deleteFood($id)
    {

        //Gets current user
        $Auth = Auth::user();

        if ($Auth->role == "ADMIN") {

            //Deletes food data based on primary key
            $delete = foodModel::where('id_menu', $id)->delete();
            return response()->json($delete);

        } else {
            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Admin yang bisa menghapus'], status: 500);
        }

    }
    
}
