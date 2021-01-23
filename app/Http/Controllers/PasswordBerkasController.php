<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordBerkas;

class PasswordBerkasController extends Controller
{
    public function index()
    {
        return view('password-berkas.index');
    }

    public function update(Request $request)
    {
        // return $request->password;
        $this->validate($request,[
            'password' => 'required|min:6|max:255',
            'password_ulang' => 'required|same:password'
            
        ],[
           'password.required'=>'Password Tidak Boleh Kosong',
           'password_ulang.required'=>'Re Password Tidak Boleh Kosong',
           'password.min'=>'Password Minimal 6 character',
           'password_ulang.same'=>'Password Tidak Sama',

        ]);        
        $data = PasswordBerkas::first();
        $data->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Berhasil', 'data' => $data]);
    }
}
