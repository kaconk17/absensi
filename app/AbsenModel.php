<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenModel extends Model
{
    public $incrementing = false;
    protected $table = 'tb_absensi';
    protected $primaryKey = "id_absensi";
    protected $fillable = [
        'id_absensi',
        'id_user',
        'tanggal',
        'jam',
        'lat',
        'long',
        'jarak',
        'status',
        'keterangan',
        
    ];
}
