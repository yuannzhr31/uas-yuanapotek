<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trn extends Model
{
    use HasFactory;
    protected $fillable = [
        'no',
        'id_transaksi',
        'nama_pembeli',
        'nama_obat',
        'harga_obat',

    ];
}
