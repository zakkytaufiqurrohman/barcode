<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordBerkas extends Model
{
    protected $table = 'tbl_password_berkas';
    protected $fillable = ['password','v'];
    protected $primaryKey = 'id_password';
}
