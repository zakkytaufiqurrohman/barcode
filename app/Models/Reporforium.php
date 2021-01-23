<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporforium extends Model
{
    protected $table = 'tbl_reporforium';
    protected $primaryKey = 'id_reporforium';
    protected $fillable = ['nomor','no_bulanan','tanggal','sifat_akta','sk_kemenhumkam','berkas','id_berkas', 'created_at', 'updated_at'];

    public function berka()
    {
        return $this->belongsTo(Berkas::class,'id_berkas','id_berkas');
    }

    public function users()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }
    
    public function detailrepo()
    {
        return $this->hasMany(DetailReporforium::class,'id_reporforium','id_reporforium');
    }

}
