<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foodModel extends Model
{
    use HasFactory;

    protected $table = 'menu';

    public $timestamps = false;
    
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'nama_menu',
        'jenis',
        'deskripsi',
        'gambar',
        'harga',
    ];
}


