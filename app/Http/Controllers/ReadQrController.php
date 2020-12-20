<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waarmeking;
use App\Models\Berkas;

class ReadQrController extends Controller
{
    public function readQR($id)
    {
        $berkas = Berkas::with('waarmeking')->where('kode_berkas',$id)->first();

        return $berkas->waarmeking->nomor;
    }

    public function readQROld($nama,$id)
    {
        $berkas = Berkas::with('waarmeking')->where('kode_berkas',$id)->first();

        return $berkas->waarmeking->nomor;
    }
}
