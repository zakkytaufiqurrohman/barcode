<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kwitansi extends Model
{
    // use SoftDeletes;

    protected $table = 'tbl_kwitansi';
    protected $primaryKey = 'id_kwitansi';
    protected $fillable = ['nomor','tanggal','terima','catatan','penyetor', 'mengetahui', 'penerima','id_berkas', 'created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public function berkas()
    {
        return $this->belongsTo(Berkas::class,'id_berkas','id_berkas');
    }

    public function uraian()
    {
        return $this->belongsTo(Uraian::class,'id_kwitansi','id_kwitansi');
    }

    public function users()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }

    public function urai()
    {
        return $this->hasMany(Uraian::class,'id_kwitansi','id_kwitansi');
    }
}
