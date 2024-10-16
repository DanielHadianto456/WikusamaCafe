<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\detailTransaksiModel;
use App\Models\foodModel;
use App\Models\transaksiModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class detailTransaksiController extends Controller
{

    //Function used to get all data from table
    public function getAll()
    {

        $data = detailTransaksiModel::all();
        return response()->json($data);

    }

    //Function used to get data based on DETAIL primary key
    public function getDetailId($id)
    {

        $data = detailTransaksiModel::with('detailMenu')->find($id);
        return response()->json($data);

    }

    //Function used to get data based on TRANSAKSI primary key
    public function getDetailTransaksiId($id)
    {

        // Gets current user
        $Auth = Auth::user();

        // Fetches all transaction details with related data
        $data = detailTransaksiModel::with(['detailTransaksi.detailPegawai', 'detailMenu'])
            ->where('id_transaksi', $id)
            ->get();

        // Check if any of the transaction details belong to the authenticated user
        $isAuthorized = $data->contains(function ($item) use ($Auth) {
            return $item->detailTransaksi->id_user == $Auth->id_user;
        });

        // Check if the current user is a manager
        if ($Auth->role == 'KASIR' || $Auth->role == 'MANAJER') {

            // Checks if the user is included in the transaction details
            // or the current user is a manager
            if ($isAuthorized || $Auth->role == 'MANAJER') {

                return response()->json($data);

            } else {

                return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);

            }

        } else {

            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);

        }

    }

    // Function used to create transaction detail
    public function addDetailTransaksi(Request $request, $id) // INPUT id_transaksi FOR $id
    {
        // Gets current user
        $Auth = Auth::user();

        // Gets transaction data based on primary key from $request
        $CheckTransaction = transaksiModel::find($id);

        // Checks if user is "KASIR"
        if ($Auth->role == "KASIR") {

            // Checks if status is set to "BELUM_BAYAR"
            if ($CheckTransaction->status == "BELUM_BAYAR") {

                if ($Auth->id_user == $CheckTransaction->id_user) {

                    // Creates a validator to validate the array of menu inputs
                    $validator = Validator::make($request->all(), [
                        'menu_items' => 'required|array',
                        'menu_items.*.id_menu' => 'required|integer',
                    ]);

                    // Checks if validator occurs an error or not
                    if ($validator->fails()) {
                        return response()->json($validator->errors()->toJson());
                    }

                    // Initialize an array to store results
                    $results = [];

                    // Loop through each menu item in the request
                    foreach ($request->menu_items as $menuItem) {
                        // Gets food data based on primary key from each menu item
                        $CheckFood = foodModel::find($menuItem['id_menu']);

                        if ($CheckFood) {
                            // Creates a variable to save inputted data for each menu item
                            $save = detailTransaksiModel::create([
                                'id_transaksi' => $id, // id_transaksi is taken from $id in parameter
                                'id_menu' => $menuItem['id_menu'],
                                'harga' => $CheckFood->harga,
                            ]);

                            // Add the result of each save operation to the results array
                            $results[] = $save ? ['status' => true, 'id_menu' => $menuItem['id_menu'], 'message' => 'Berhasil Menambah']
                                : ['status' => false, 'id_menu' => $menuItem['id_menu'], 'message' => 'Gagal Menambah'];
                        } else {
                            // If the menu item is not found, add an error to the results
                            $results[] = ['status' => false, 'id_menu' => $menuItem['id_menu'], 'message' => 'Menu not found'];
                        }
                    }

                    // Return all the results after processing the array
                    return response()->json($results, status: 200);

                } else {
                    return response()->json(['status' => false, 'message' => 'Unauthorized'], status: 401);
                }

            } else {
                return response()->json(['status' => false, 'message' => 'Gagal, transaksi sudah lunas'], status: 500);
            }

        } else {
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menambah'], status: 500);
        }
    }

    // public function addDetailTransaksi(Request $request, $id) // INPUT id_transaksi FOR $id
    // {

    //     //Gets current user
    //     $Auth = Auth::user();

    //     //Gets food data based on primary key from $request
    //     $CheckFood = foodModel::find($request->id_menu);

    //     //Gets transaction data based on primary key from $request
    //     $CheckTransaction = transaksiModel::find($id);

    //     //Checks if user is "KASIR"
    //     if ($Auth->role == "KASIR") {

    //         //Checks if status is set to "BELUM_BAYAR"
    //         if ($CheckTransaction->status == "BELUM_BAYAR") {

    //             //Creates a validator to validate inputs
    //             $validator = Validator::make($request->all(), [
    //                 'id_menu' => 'required|Integer',
    //             ]);

    //             //Checks if validator occurs an error or not
    //             if ($validator->fails()) {

    //                 //Returns an error if so
    //                 return response()->json($validator->errors()->toJson());

    //             }

    //             //Creates a variable to save inputted data
    //             $save = detailTransaksiModel::create([
    //                 'id_transaksi' => $id, //id_transaksi is taken from $id in parameter
    //                 'id_menu' => $request->id_menu,
    //                 'harga' => $CheckFood->harga,
    //             ]);

    //             //Checks if save is successful
    //             if ($save) {

    //                 //If the $save is successful, return a 200 response
    //                 // with a success message
    //                 return response()->json(['status' => true, 'message' => 'Berhasil Menambah'], status: 200);

    //             } else {

    //                 //else returns an error
    //                 return response()->json(['status' => false, 'message' => 'Gagal menambah'], status: 500);

    //             }

    //         } else {

    //             //else returns an error
    //             return response()->json(['status' => false, 'message' => 'Gagal, transaksi sudah lunas'], status: 500);

    //         }

    //     } else {

    //         //else returns an error
    //         return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menambah'], status: 500);

    //     }

    // }

    //Function used to update transaction detail
    public function updateDetailTransaksi(Request $request, $id)// INPUT id_detail_transaksi FOR $id
    {

        //Gets current user
        $Auth = Auth::user();

        //Gets food data based on primary key from $request
        $Check = foodModel::find($request->get('id_menu'));

        //Gets transaction detail data based on primary key 
        $CheckTransactionDetail = detailTransaksiModel::find($id);

        //Gets transaction data based on primary key
        //provided by $CheckTransactionDetail
        $CheckTransaction = transaksiModel::find($CheckTransactionDetail->id_transaksi);

        //Checks if user's role is "KASIR"
        if ($Auth->role == "KASIR") {

            //Checks if status is set to "BELUM_BAYAR"
            if ($CheckTransaction->status == "BELUM_BAYAR") {

                //Creates a validator to validate inputs
                $validator = Validator::make($request->all(), [
                    'id_menu' => 'required|Integer',
                ]);

                //Checks if validator occurs an error or not
                if ($validator->fails()) {

                    //Returns an error if so
                    return response()->json($validator->errors()->toJson());

                }

                //Creates a variable to save inputted data
                $save = detailTransaksiModel::find($id)->update([
                    'id_menu' => $request->id_menu,
                    'harga' => $Check->harga,
                ]);

                //Checks if save is successful
                if ($save) {

                    //If the $save is successful, return a 200 response
                    // with a success message
                    return response()->json(['status' => true, 'message' => 'Berhasil Mengubah'], status: 200);

                } else {

                    //else returns an error
                    return response()->json(['status' => false, 'message' => 'Gagal mengubah'], status: 500);

                }

            } else {

                //else returns an error
                return response()->json(['status' => false, 'message' => 'Gagal, karena transaksi sudah lunas'], status: 500);

            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa mengubah'], status: 500);

        }

    }

    //Function used to delete transaction detail
    public function deleteDetailTransaksi($id)
    {
        //Checks current user
        $Auth = Auth::user();

        //Gets transaction detail data based on primary key 
        $CheckTransactionDetail = detailTransaksiModel::find($id);

        //Gets transaction data based on primary key
        //provided by $CheckTransactionDetail
        $CheckTransaction = transaksiModel::find($CheckTransactionDetail->id_transaksi);

        //Checks if user's role is "KASIR"
        if ($Auth->role == "KASIR") {

            //Checks if status transaksi is "BELUM_BAYAR"
            if ($CheckTransaction->status == "BELUM_BAYAR") {

                //Checks if the transaction detail belongs to the authenticated user
                if ($CheckTransaction->id_user == $Auth->id_user) {

                    $delete = detailTransaksiModel::find($id)->delete();
                    response()->json($delete);

                } else {

                    //else returns an error
                    return response()->json(['status' => false, 'message' => 'Unauthorized'], status: 500);

                }

            } else {

                //else returns an error
                return response()->json(['status' => false, 'message' => 'Gagal, karena transaksi sudah lunas'], status: 500);

            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menghapus'], status: 500);

        }

    }

    // Function to delete multiple transaction details by id_menu within a specific transaction (id_transaksi)
public function deleteMultipleByMenuAndTransaction($id_transaksi, $id_menu)
{
    // Get current user
    $Auth = Auth::user();

    // Check if the current user's role is "KASIR"
    if ($Auth->role == "KASIR") {

        // Get all transaction details where both id_menu and id_transaksi match
        $details = detailTransaksiModel::where('id_menu', $id_menu)
                                        ->where('id_transaksi', $id_transaksi)
                                        ->get();

        if ($details->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No items found with the given menu ID in this transaction'], 404);
        }

        // Check the status of the transaction and user authorization
        $CheckTransaction = transaksiModel::find($id_transaksi);

        if ($CheckTransaction->status == "BELUM_BAYAR" && $CheckTransaction->id_user == $Auth->id_user) {
            // Delete all matching records
            foreach ($details as $detail) {
                $detail->delete();
            }

            return response()->json(['status' => true, 'message' => 'Items successfully deleted'], 200);
        } else {
            return response()->json([
                'status' => false, 
                'message' => 'Cannot delete, either unauthorized or the transaction is already completed'
            ], 403);
        }
    } else {
        // Return an error if the user is not authorized
        return response()->json(['status' => false, 'message' => 'Only KASIR can delete items'], 403);
    }
}


}
