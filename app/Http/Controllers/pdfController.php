<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\transaksiModel;
use Illuminate\Support\Facades\Log;

class pdfController extends Controller
{
    public function getPdf($id)
    {
        $transaction = transaksiModel::with([
            'detailPegawai',
            'detailMeja',
            'detailTransaksi.detailMenu',
        ])->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $totalHarga = $transaction->detailTransaksi->sum('harga');

        $data = [
            'title' => 'WikusamaCafe Reciept',
            'date' => date('m/d/Y'),
            'transaction' => $transaction,
            'totalHarga' => $totalHarga
        ];

        try {
            $pdf = Pdf::loadView('invoice.generate-invoice-pdf', $data);
            return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {
            Log::error('PDF generation error: ' . $e->getMessage());
            return response()->json(['message' => 'Error generating PDF'], 500);
        }
    }
}