<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifPengadaanM extends Model
{
    use HasFactory;

    protected $table = 'notif_pengadaan';

    protected $fillable = [
        'title',
        'value',
        'pengirm_id',
        'status',
    ];
}
