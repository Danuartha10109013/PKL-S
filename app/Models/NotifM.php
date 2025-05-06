<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifM extends Model
{
    use HasFactory;

    protected $table = 'notif';
    protected $fillable = [
        'judul',
        'no_jobcard',
        'jumlah_pengadaan',
        'user_id',
        'material_id',
        'po_id',
    ];
}
