<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class transaksiModel extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsTo(userModel::class, 'id_user', 'id_user')->withTrashed();
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
