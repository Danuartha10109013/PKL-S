<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POM extends Model
{
    use HasFactory;
    protected $table = 'po';
    protected $fillable = [
        'nomor_po',
        'tanggal_penawaran',
        'nama_customer',
        'product',
        'no_penawaran',
        'status_penawaran',
        'tanggal_permintaan',
        'tanggal_terima_po',
        'harga_ditawarkan',
        'harga_disetujui',
        'catatan',
        'status',
    ];
}
