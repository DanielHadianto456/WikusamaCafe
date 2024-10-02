<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transaksiModel;
use App\Models\tableModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class transaksiController extends Controller
{

    //Function used to get all data from table
    public function getTransaksi()
    {
        $data = transaksiModel::with([
            'detailPegawai',
            'detailMeja',
            'detailTransaksi.detailMenu',
        ])->get();
        return response()->json($data);
    }

    //Function used to get data based on primary key
    public function getTransaksiId($id)
    {

        $data = transaksiModel::with([
            'detailPegawai',
            'detailMeja',
            'detailTransaksi.detailMenu',
        ])->find($id);
        return response()->json($data);

    }

    //Function used to get data based on date
    public function getDate(Request $request){

        //Gets current user
        $Auth = Auth::user();

        //Checks if user is manager or not
        if($Auth->role == 'MANAJER'){

            //Gets data based on date
            $data = transaksiModel::with([
                'detailPegawai',
                'detailMeja',
                'detailTransaksi.detailMenu',
            ])->whereDate('tanggal_transaksi', $request->get('tanggal_transaksi'))->get();
            return response()->json($data);

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Manajer yang bisa mengakses'], status: 500);

        }

    }

    //Function used to make a transaction
    public function addTransaksi(Request $request)
    {

        //Gets current user
        $Auth = Auth::user();

        //Gets table data based on primary key
        //provided from $request in the parameter
        $check = tableModel::find($request->get('id_meja'));

        //Checks if current user is cashier
        if ($Auth->role == "KASIR") {

            //Checks if selected table is used
            if ($check->status == "DIGUNAKAN") {

                //Returns an error if so
                return response()->json(['status' => false, 'message' => 'Meja sudah digunakan'], status: 500);

            } else {

                //Creates a validator
                $validator = Validator::make($request->all(), [
                    'id_meja' => 'required|Integer',
                    'nama_pelanggan'
                ]);

                //Checks if validator occurs an error or not
                if ($validator->fails()) {

                    //Returns an error if so
                    return response()->json($validator->errors()->toJson());

                }

                //Creates a variable to save inputted data
                $save = transaksiModel::create([
                    'id_user' => $Auth->id_user,
                    'id_meja' => $request->get('id_meja'),
                    'nama_pelanggan' => $request->get('nama_pelanggan'),
                    'status' => 'BELUM_BAYAR',
                    'tanggal_transaksi' => now(),
                ]);


                //Checks if save is successful
                if ($save) {

                    //Changes the status of selected table into "DIGUNAKAN"
                    //So that it can't be used unless it's not used anymore
                    tableModel::find($request->id_meja)->update([
                        'status' => 'DIGUNAKAN',
                    ]);

                    // If the $save is successful, return a 200 response
                    // with a success message
                    return response()->json($save);

                } else {

                    // If the $save is not successful, return a 500 response
                    // with an error message
                    return response()->json(['status' => false, 'message' => 'Gagal menambah'], status: 500);

                }
            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menambah'], status: 500);

        }

    }

    //Function used to pay off transactions
    public function updateTransaksi($id)
    {
        //Gets current user
        $Auth = Auth::user();

        //Gets transaction data based on $id
        $check = transaksiModel::find($id);

        //Checks if current user is cashier
        if ($Auth->role == "KASIR") {

            //Changes the status of selected transaction into "LUNAS"
            $update = transaksiModel::where('id_transaksi', $id)->update([
                'status' => 'LUNAS',
            ]);

            //Checks if save is successful
            if ($update) {

                //Changes the status of selected table into "KOSONG"
                //So that it can be used again
                tableModel::find($check->id_meja)->update([
                    'status' => 'KOSONG',
                ]);

                // If the $save is successful, return a 200 response
                // with a success message
                return response()->json(['status' => true, 'message' => 'Sukses membayar'], status: 200);

            } else {

                // If the $save is not successful, return a 500 response
                // with an error message
                return response()->json(['status' => false, 'message' => 'Gagal membayar'], status: 500);

            }

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa memperbarui'], status: 500);

        }

        //Function used to delete selected transaction record

    }
    public function deleteTransaksi($id)
    {

        //Gets current user
        $Auth = Auth::user();

        if ($Auth->role == "KASIR") {

            //Deletes transaction data based on primary key taken from $id
            $delete = transaksiModel::find($id)->delete();
            response()->json($delete);

        } else {

            //else returns an error
            return response()->json(['status' => false, 'message' => 'Hanya Kasir yang bisa menghapus'], status: 500);

        }

    }

}
