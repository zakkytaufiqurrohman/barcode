<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporforium extends Model
{
    protected $table = 'tbl_reporforium';
    protected $fillable = ['nomor','no_bulanan','tanggal','sifat_akta','sk_kemenhumkam','berkas'];
}
