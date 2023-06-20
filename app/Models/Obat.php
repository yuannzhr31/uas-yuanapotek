<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_obat', 
        'golongan_obat', 
        'nama_obat',
        'khasiat',
    ];

    public function detail()
    {
        return $this->hasMany(Detail::class, 'id_obat', 'id_obat');
    }

    public function getManager()
    {
        return $this->belongsTo(User::class, 'golongan_obat', 'id');
    
    }
}
