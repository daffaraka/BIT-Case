<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'saldo_awal',
        'saldo_akhir',
        'judul_transaksi',
        'deskripsi_transaksi',
        'nominal_transaksi',
        'type_transaksi',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
