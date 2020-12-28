<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TandaTerima extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_tandaterima';
    protected $primaryKey = 'id_tandaterima';
    protected $fillable = ['judul','pembuat','nomor','tanggal','isi','id_berkas', 'created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public function berkas()
    {
        return $this->belongsTo(Berkas::class,'id_berkas','id_berkas');
    }

    public function users()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }
}
