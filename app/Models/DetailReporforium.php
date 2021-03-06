<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReporforium extends Model
{
    
    protected $table = 'detail_reporforium';
    protected $primaryKey = 'id_detail_reporforium';
    protected $fillable = ['id_reporforium','foto','nik','nama'];

    public function users()
    {
        return $this->belongsTo('App\User','id_user','id_user');
    }

    public function reporforium()
    {
        return $this->hasOne(Reporforium::class,'id_reporforium','id_reporforium');
    }

    // public function reporforiums()
    // {
    //     return $this->belongsToMany(Reporforium::class,'id_reporforium','id_reporforium');
    // }
}
