<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;


class LandingController extends Controller
{
public function index()
{
// Data contoh yang ditampilkan di landing page
$features = [
['title' => 'Input & Kelola Barang', 'desc' => 'Tambah, edit, dan atur stok barang dengan mudah.'],
['title' => 'Notifikasi Kadaluarsa', 'desc' => 'Barang kadaluarsa otomatis ditandai dan tidak bisa dijual.'],
['title' => 'Laporan Penjualan', 'desc' => 'Lihat total penjualan, keuntungan, dan riwayat user.'],
['title' => 'Scan Barcode & Cetak Struk', 'desc' => 'Proses cepat dengan barcode, struk tercetak otomatis.'],
['title' => 'Manajemen Role', 'desc' => 'Admin, Pegawai, Customer, dan Member dengan hak berbeda.'],
['title' => 'Diskon Member', 'desc' => 'Member mendapatkan potongan harga khusus.'],
];


$roles = [
['role' => 'Admin', 'desc' => 'Akses penuh: laporan, user, katalog, keuntungan.'],
['role' => 'Pegawai', 'desc' => 'Proses transaksi, lihat katalog, cetak struk.'],
['role' => 'Customer Biasa', 'desc' => 'Lihat katalog, daftar member saat checkout.'],
['role' => 'Member', 'desc' => 'Diskon eksklusif & kode pembayaran/stripe.'],
];


return view('landing.index', compact('features', 'roles'));
}
}