<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Aplikasi Kasir Modern')</title>
<!-- Tailwind Play CDN untuk prototyping cepat -->
<script src="https://cdn.tailwindcss.com"></script>
<meta name="description" content="Sistem kasir, manajemen stok, laporan penjualan, dan member." />
</head>
<body class="antialiased text-slate-800 bg-slate-50">
@include('partials.navbar')


<main class="container mx-auto px-4 py-12">
@yield('content')
</main>


<footer class="bg-white border-t mt-12">
<div class="container mx-auto px-4 py-8 text-sm text-slate-600">
<div class="flex flex-col md:flex-row md:justify-between">
<div>
<h3 class="font-semibold">Nama Aplikasi Kasir</h3>
<p>Alamat Toko • Nomor Telepon</p>
</div>
<div class="mt-4 md:mt-0">
<p>© {{ date('Y') }} Nama Aplikasi. All rights reserved.</p>
</div>
</div>
</div>
</footer>
</body>
</html>




