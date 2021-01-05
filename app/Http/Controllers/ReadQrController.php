<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waarmeking;
use App\Models\Berkas;
use App\Models\PasswordBerkas;

class ReadQrController extends Controller
{
    public function readQROld($nama,$id)
    {
        return view('readQr',compact('id','nama'));
    }

    public function login(Request $request)
    {
        $id = $request->id;
        $nama = $request->nama;
        $password = addslashes($request->password);
        $data = PasswordBerkas::first();
        if(!empty($data)){
            if(password_verify($password,$data->password)){
                $_SESSION['username'] = $data->password;
                return view('readQr',compact('id','nama'));
            }
            else {
                return redirect()->back()->with('error','Password Salah');
            }
        }
        return redirect()->back()->with('error','Password Salah');
    }
}
