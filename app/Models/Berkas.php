<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Berkas extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_berkas';
    protected $primaryKey = 'id_berkas';
    protected $fillable = ['tipe_berkas','id_user','tanggal','waktu','password_berkas', 'password', 'kode_berkas', 'created_at','updated_at'];
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }

    public function waarmeking()
    {
        return $this->hasOne(waarmeking::class,'id_berkas','id_berkas');
    }
}
