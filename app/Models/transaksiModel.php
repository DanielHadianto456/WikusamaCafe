<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksiModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    public $timestamps = false;

    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'tanggal_transaksi',
        'id_user',
        'id_meja',
        'nama_pelanggan',
        'status'
    ];

    public function detailPegawai()
    {
        return $this->belongsTo(userModel::class, 'id_user', 'id_user');
    }

    public function detailMeja()
    {
        return $this->belongsTo(tableModel::class, 'id_meja', 'id_meja');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(detailTransaksiModel::class, 'id_transaksi', 'id_transaksi');
    }

}
