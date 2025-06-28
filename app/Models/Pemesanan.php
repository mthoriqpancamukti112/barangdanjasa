<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini
    protected $table = 'pemesanan';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'id_metode_pembayaran',
        'total_harga',
        'status',
        'tgl_pemesanan',
    ];

    // Relasi dengan model DetailPemesanan
    public function details()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pemesanan');
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi dengan model MetodePembayaran
    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan');
    }

    // Definisi relasi dengan model Pengiriman
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_pemesanan');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
