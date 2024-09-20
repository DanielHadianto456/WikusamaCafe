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

        $data = detailTransaksiModel::with('detailMenu')->where('id_transaksi', $id)->get();
        return response()->json($data);

    }

    //Function used to create transaction detail
    public function addDetailTransaksi(Request $request, $id) // INPUT id_transaksi FOR $id
    {

        //Gets current user
        $Auth = Auth::user();

        //Gets food data based on primary key from $request
        $CheckFood = foodModel::find($request->id_menu);

        //Gets transaction data based on primary key from $request
        $CheckTransaction = transaksiModel::find($id);

        //Checks if user is "KASIR"
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
                $save = detailTransaksiModel::create([
                    'id_transaksi' => $id, //id_transaksi is taken from $id in parameter
                    'id_menu' => $request->id_menu,
                    'harga' => $CheckFood->harga,
                ]);

                //Checks if save is successful
                if ($save) {

                    //If the $save is successful, return a 200 response
                    // with a success message
                    return response()->json(['status' => true, 'message' => 'Berhasil Menambah'], status: 200);

                } else {

                    //else returns an error
                    return response()->json(['status' => false, 'message' => 'Gagal menambah'], status: 500);

                }

            } else {

                //else returns an error
                return response()->json(['status' => false, 'message' => 'Gagal, transaksi sudah lunas'], status: 500);

            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menambah'], status: 500);

        }

    }

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

                $delete = detailTransaksiModel::find($id)->delete();
                response()->json($delete);

            } else {

                //else returns an error
                return response()->json(['status' => false, 'message' => 'Gagal, karena transaksi sudah lunas'], status: 500);

            }


        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menghapus'], status: 500);

        }

    }

}
