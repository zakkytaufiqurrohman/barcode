<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waarmeking;
use App\Models\Covernot;
use App\Models\Legalisasi;
use App\Models\AktaNotaris;
use App\Models\AktaJaminanFidusia;
use App\Models\TandaTerimav2;
use App\Models\Ppat;
use App\Models\Kwitansi;
use App\Models\Reporforium;
use App\User;

class HomeController extends Controller
{
     public function index()
     {
         $waarmeking = Waarmeking::count();
         $covernot = Covernot::count();
         $legalisasi = Legalisasi::count();
         $aktaNotaris = AktaNotaris::count();
         $aktaJaminanFidusia = AktaJaminanFidusia::count();
         $tandaTerimav2 = TandaTerimav2::count();
         $ppat = Ppat::count();
         $kwitansi = Kwitansi::count();
         $reporforium = Reporforium::count();
         $user = Reporforium::count();

         return view ('home',compact('waarmeking','covernot','legalisasi','aktaNotaris','aktaJaminanFidusia','tandaTerimav2','ppat','kwitansi','reporforium','user'));
     }
}
