<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktaPpat extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_aktappat';
    protected $primaryKey = 'id_aktappat';
    protected $fillable = ['judul','nomor','tanggal','pihak1','pihak2','objek','id_berkas', 'created_at', 'updated_at'];
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
