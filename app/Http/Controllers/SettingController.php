<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $data = Setting::first();
        return view('setting.index',compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'header' =>'required|mimes:jpg,png',
        ]);

        $file = $request->header;
        $text = str_replace(' ', '',$file->getClientOriginalName());
        $nama_file = time()."_".$text;
        //hapus file lama
        
        $file->move(public_path('settings'),$nama_file);
        $update = Setting::find($request->id);
        if(empty($update)){
            Setting::create([
                'header' => $nama_file,
            ]);
        }
        else {
            // if (file_exists(public_path('settings/').$update->header))
            // {
                $image_path = public_path('settings/').$update->header;
                unlink($image_path);
            // }
            $update->update([
                'header' => $nama_file,
            ]);
           
        }
        
        return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan']);
        // return $request->header;
    }
}
