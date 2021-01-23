<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TandaTerimav2 extends Model
{
    use SoftDeletes;

    protected $table = 'tandaterima';
    protected $primaryKey = 'id_tandaterima';
    protected $fillable = ['terima','berupa','keperluan','tanggal','penerima','penyerah','id_berkas', 'created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public function berkas()
    {
        return $this->belongsTo(Berkas::class,'id_berkas','id_berkas');
    }
}
