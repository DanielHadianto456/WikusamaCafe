<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailTransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';

    protected $primaryKey = 'id_detail_transaksi';

    public $timestamps = false;
    
    protected $fillable = [
        'id_transaksi',
        'id_menu',
        'harga',
    ];

    public function detailMenu(){
        return $this->belongsTo(foodModel::class, 'id_menu', 'id_menu');
    }

}
