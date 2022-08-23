<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ongkos extends Model
{
    protected $table = 'ongkos';
    protected $guarded = [];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'pengadaan_id');
    }
}
