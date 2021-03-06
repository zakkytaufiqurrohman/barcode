<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        if(auth::user()->level_user == 'Superadmin' || auth::user()->level_user == 'Admin'){
            $data = Setting::first();
            return view('setting.index',compact('data'));
        }
        return 'Akun anda tidak punya wewenang';
       
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'header' =>'mimes:jpg,png',
        ]);

        $file = $request->header;
        $update = Setting::find($request->id);
        if (!empty($file)){
            $text = str_replace(' ', '',$file->getClientOriginalName());
            $nama_file = time()."_".$text;
            $file->move(public_path('settings'),$nama_file);
            $image_path = public_path('settings/').$update->header;
            if (file_exists(public_path('settings/').$update->header)){
                unlink($image_path);
            }
        }
        else {
            $nama_file = $update->header;
           
        }
        
        if(empty($update)){
            Setting::create([
                'header' => $nama_file,
                'nama' => $request->nama,
            ]);
        }
        else {
            $update->update([
                'header' => $nama_file,
                'nama' => $request->nama,
            ]);
           
        }
        return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan']);
        // return $request->header;
    }
}
