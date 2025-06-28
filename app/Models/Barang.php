<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'image',
        'nama_barang',
        'harga_barang',
        'stok',
        'deskripsi',
        'bisa_disewa',
    ];
}