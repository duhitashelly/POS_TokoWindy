<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .struk-container {
            background-color: white;
            padding: 20px;
            width: 300px; 
            position: ;
            top: 0; 
            left: 0; 
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-size: 20px; /* Ukuran font lebih kecil */
            font-weight: bold;
        }

        .header p {
            margin: 5px 0; /* Memberi sedikit jarak antar teks */
            font-size: 12px; /* Ukuran font kecil untuk kode struk, tanggal, dan kasir */
            color: #555; /* Warna teks lebih lembut */
        }

        .details {
            margin-bottom: 15px;
        }

        .items {
            margin-bottom: 20px;
        }

        .items .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .totals {
            margin-top: 20px;
        }

        .totals .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .totals .row span:first-child {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            border-top: 2px solid #e0e0e0;
            padding-top: 15px;
            margin-top: 15px;
        }

        .footer p {
            font-size: 14px;
            color: #555;
        }

        /* Button print */
        .btn-print {
            display: block;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 20px;
            margin-top: 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .struk-container {
                box-shadow: none;
                border-radius: 0;
                position: fixed; 
                top: 0; 
                left: 0; 
                margin: 0;
                padding: 20px;
                border: 1px solid #7d7d7d; 
                width: 300px; 
                font-size: 14px;
            }

            .footer {
                margin-top: 0px;
            }
        }
    </style>
</head>

<body>
    <div class="struk-container">
        <div class="header">
            <h1>Toko Windy</h1>
            <p>Kode Struk: {{ $struk['kode_struk'] }}</p>
            <p>Tanggal: {{ $struk['tanggal'] }}</p>
            <p>Kasir: {{ $struk['kasir'] }}</p>
        </div>
        <div class="details">
            <strong>Detail Barang:</strong>
        </div>
        <div class="items">
            @foreach ($struk['items'] as $item)
                <div class="item">
                    <span>{{ $item['nama_barang'] }} (x{{ $item['qty'] }})</span>
                    <span>Rp {{ number_format($item['total_harga'], 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
        <div class="totals">
            <div class="row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($struk['subtotal'], 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Bayar:</span>
                <span>Rp {{ number_format($struk['bayar'], 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Kembalian:</span>
                <span>Rp {{ number_format($struk['kembalian'], 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="footer">
            <p>Terima kasih sudah mampir ke Toko Windy 😉</p>
        </div>
    </div>
</body>

</html>
