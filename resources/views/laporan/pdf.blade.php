<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Transaksi</h2>
    <p>Periode: {{ $start_date }} s/d {{ $end_date }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga Barang</th>
                <th>Total Harga Barang</th>
                <th>Sub Total</th>
                <th>Jumlah Bayar</th>
                <th>Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->barang_id }}</td>
                    <td>{{ $transaction->nama_barang }}</td>
                    <td>{{ $transaction->qty }}</td>
                    <td>{{ number_format($transaction->harga_barang, 0, ',', '.') }}</td>
                    <td>{{ number_format($transaction->total_harga_barang, 0, ',', '.') }}</td>
                    <td>{{ number_format($transaction->sub_total, 0, ',', '.') }}</td>
                    <td>{{ number_format($transaction->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Keseluruhan: {{ number_format($totalKeseluruhan, 0, ',', '.') }}</p>
    </div>
</body>
</html>
