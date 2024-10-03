<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        img { max-width: 100px; height: auto; }
    </style>
</head>
<body>
    <h2>Title: {{ $title }}</h2>
    <h2>Date: {{ $date }}</h2>
    <h3>Customer: {{ $transaction->nama_pelanggan }}</h3>
    <h3>Table Number: {{ $transaction->detailMeja->nomor_meja }}</h3>
    <h3>Cashier: {{ $transaction->detailPegawai->nama_user }}</h3>
    <table>
        <thead>
            <tr>
                <th>Menu Item</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->detailTransaksi as $item)
                <tr>
                    <td>{{ $item->detailMenu->nama_menu }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>
                        <img src="storage/{{$item->detailMenu->gambar}}" style="height: 100px; width: 100px">
                        {{-- <img src="localhost:8000{{ asset('storage/' . $item->detailMenu->gambar) }}"> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<style>
    
</style>