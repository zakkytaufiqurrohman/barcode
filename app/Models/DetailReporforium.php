<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReporforium extends Model
{
    
    protected $table = 'detail_reporforium';
    protected $fillable = ['id_reporforium','foto','nik'];
}
