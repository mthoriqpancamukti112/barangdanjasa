<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $table = 'penyewaans';

    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'barang_id',
        'tgl_mulai',
        'tgl_selesai',
        'jumlah',
        'total_harga',
        'status'
    ];

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'penyewaan_id');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'penyewaan_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'penyewaan_id');
    }
}
