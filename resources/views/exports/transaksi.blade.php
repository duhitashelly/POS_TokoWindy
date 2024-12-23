<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #555;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .periode {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="periode">
        <p>Periode: {{ $startDate }} - {{ $endDate }}</p>
    </div>

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
                <td>{{ $transaction->nota }}</td>
                <td>{{ $transaction->barang_id }}</td>
                <td>{{ $transaction->nama_barang }}</td>
                <td>{{ $transaction->qty }}</td>
                <td>{{ 'Rp ' . number_format($transaction->harga_barang, 0, ',', '.') }}</td>
                <td>{{ 'Rp ' . number_format($transaction->total_harga_barang, 0, ',', '.') }}</td>
                <td>{{ 'Rp ' . number_format($transaction->sub_total, 0, ',', '.') }}</td>
                <td>{{ 'Rp ' . number_format($transaction->jumlah_bayar, 0, ',', '.') }}</td>
                <td>{{ 'Rp ' . number_format($transaction->kembalian, 0, ',', '.') }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="10">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        <p>Total Keseluruhan: {{ number_format($total, 2, ',', '.') }}</p>
    </div>
</body>
</html>