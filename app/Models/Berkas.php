<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table = 'tbl_berkas';
    protected $fillable = ['tipe_berkas','id_user','tanggal','waktu','password_berkas', 'password', 'kode_berkas', 'created_at','updated_at'];
    public function waarmeking()
    {
    	return $this->hasOne('App\Models\Waarmeking');
    }
}
