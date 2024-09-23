<?php

use App\Http\Controllers\SaldoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Models\Transaksi;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {

        $data['judul'] = 'Dashboard';
        $data['transaksi'] = Transaksi::count();
        $data['pendapatan'] = Transaksi::whereTypeTransaksi('pendapatan')->count();
        $data['pengeluaran'] = Transaksi::whereTypeTransaksi('pengeluaran')->count();

        return view('admin.admin-dashboard', $data);
    })->name('dashboard');
    Route::resource('saldo', SaldoController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::get('filter-transaksi',[TransaksiController::class,'filter'])->name('transaksi.filter');
});


include 'auth.php';
