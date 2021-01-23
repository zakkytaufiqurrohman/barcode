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
        return $this->hasOne(Waarmeking::class,'id_berkas','id_berkas');
    }

    public function covernot()
    {
        return $this->hasOne(Covernot::class,'id_berkas','id_berkas');
    }

    public function legalisasi()
    {
        return $this->hasOne(Legalisasi::class,'id_berkas','id_berkas');
    }

    public function aktaPpat()
    {
        return $this->hasOne(AktaPpat::class,'id_berkas','id_berkas');
    }

    public function aktaNotaris()
    {
        return $this->hasOne(AktaNotaris::class,'id_berkas','id_berkas');
    }

    public function aktaJaminanFidusia()
    {
        return $this->hasOne(AktaJaminanFidusia::class,'id_berkas','id_berkas');
    }

    public function tandaTerima()
    {
        return $this->hasOne(TandaTerima::class,'id_berkas','id_berkas');
    }

    public function ppat()
    {
        return $this->hasOne(Ppat::class,'id_berkas','id_berkas');
    }

    public function kwitansi()
    {
        return $this->hasOne(kwitansi::class,'id_berkas','id_berkas');
    }

    public function reporforium()
    {
        return $this->hasOne(Reporforium::class,'id_berkas','id_berkas');
    }
}
