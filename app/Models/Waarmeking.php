<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waarmeking extends Model
{
    //
    protected $table = 'tbl_waarmeking';
    protected $fillable = ['nomor','tanggal','pihak1','pihak2','isi','id_berkas', 'created_at', 'updated_at'];
    protected $primaryKey = 'id_waarmeking';
}
