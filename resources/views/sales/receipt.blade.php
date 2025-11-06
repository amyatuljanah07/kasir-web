<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
        body { font-family: monospace; width: 280px; margin: auto; }
        h3, p { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 4px 0; }
        hr { border: 1px dashed #000; }
    </style>
</head>
<body>
    <h3>KasirApp</h3>
    <p>Jl. Sudirman No. 123</p>
    <p>Telp: 0812-3456-7890</p>
    <hr>

    <p><strong>Kode: {{ $sale->barcode }}</strong></p>
    <p>Tanggal: {{ $sale->created_at->format('d/m/Y H:i') }}</p>
    <hr>

    <table>
        @foreach($sale->items as $item)
        <tr>
            <td>{{ $item->variant->variant_name }}</td>
            <td>x{{ $item->quantity }}</td>
            <td align="right">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
    </table>

    <hr>
    <p>Total: Rp{{ number_format($sale->total,0,',','.') }}</p>
    <p>Pembayaran: {{ ucfirst($sale->payment_method) }}</p>

    @if($sale->payment_method === 'tunai')
        <p>Kembalian: Rp{{ number_format($sale->change,0,',','.') }}</p>
    @endif

    <hr>
    <p>Terima kasih telah berbelanja!</p>
</body>
</html>
