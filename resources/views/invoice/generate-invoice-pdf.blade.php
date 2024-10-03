<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        h1 {
            text-decoration: underline overline;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            text-align: center;
        }

        .header,
        .footer {
            margin: 20px 0;
        }

        .header h2,
        .header h3,
        .footer h3 {
            margin: 5px 0;
        }

        .subheader {
            line-height: 20px;
            text-align: left
        }

        .text-subheader {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            table-layout: fixed;
            text-align: center
        }

        th,
        td {
            /* border: 1px solid black;
            padding: 8px;
            text-align: left; */
            padding-top: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgb(218, 218, 218);
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        .thank-you {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 style="text-decoration: underline;">WikusamaCafe Receipt</h1>
        <h3>{{ $date }}</h3>
    </div>
    <div class="subheader">
        <span class="text-subheader">Customer: {{ $transaction->nama_pelanggan }}</span> <br>
        <span class="text-subheader">Table Number: {{ $transaction->detailMeja->nomor_meja }}</span> <br>
        <span class="text-subheader">Cashier: {{ $transaction->detailPegawai->nama_user }}</span> <br>
    </div>
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
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>
                        <img src="storage/{{ $item->detailMenu->gambar }}" style="height: 100px; width: 100px">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total Price: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h3>
    {{-- <div class="footer">
        <h3>Total: Rp {{ $total_harga }}</h3>
    </div> --}}
    <div class="thank-you">
        <h4>Thank you for dining with us!</h4>
    </div>
</body>

</html>
