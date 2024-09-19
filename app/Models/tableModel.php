<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tableModel extends Model
{
    use HasFactory;

    protected $table = 'meja';

    public $timestamps = false;
    
    protected $primaryKey = 'id_meja';

    protected $fillable = [
        'nomor_meja',
        'status',
    ];
}
