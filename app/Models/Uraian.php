<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uraian extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_uraian';
    protected $primaryKey = 'id_uraian';
    protected $fillable = ['id_kwitansi', 'uraian', 'jumlah', 'created_at','updated_at'];
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }

    public function kwitansi()
    {
        return $this->hasOne(Kwitansi::class,'id_kwitansi','id_kwitansi');
    }
}
