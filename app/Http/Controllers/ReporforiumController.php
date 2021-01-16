<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailReporforium;
use App\Models\Reporforium;
use App\Models\Berkas;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReporforiumController extends Controller
{
    public function index()
    {
        return view('reporforium.index');
    }

    public function store(Request $request)
    {
        //validasi 
        // untuk foto img / untuk berkas pdf
        $this->validate($request,[
            'berkas'
        ]);
        $passwordStatus = 'OFF';
        if($request->has('password')){
               $passwordStatus= 'ON';
        }
        DB::beginTransaction();
        try{
            $berkas = Berkas::create([
                'tipe_berkas' => 'ppat',
                'id_user' => Auth::user()->id_user,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'waktu' => date('H:i:s'),
                'kode_berkas' => str_replace("/", "",bcrypt(date("Y-m-d h:i:sa").rand(10,100))),
                'password_berkas' => bcrypt(12345678),
                'password' => $passwordStatus,
            ]);

            if($berkas->id_berkas < 0 || empty($berkas->id_berkas)){
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Gagal simpan ke tabel berkas']);
            }

            $scan = $request->berkas;

            $text_scan = str_replace(' ', '',$scan->getClientOriginalName());

            $nama_file_scan = time()."_".$text_scan;
            
           
            $reporforium = Reporforium::create([
                'nomor' => $request->nomor,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'no_bulanan' => $request->no_bulanan,
                'sifat_akta' => $request->sifat_akta,
                'berkas' => $nama_file_scan,
                'sk_kemenhumkam' => $request->sk_kemenhumkam,
                'id_berkas' => $berkas->id_berkas,
            ]);
            

            $nama = $request->nama;
            $nik = $request->nik;
            $fotos = $request->foto;
           
            $i = 0;

            foreach(array_combine($nama,$nik) as $niks => $name)
            {
                if(! empty([$niks,$name]))
                {
                    $foto = $fotos[$i];
                    $text_foto = str_replace(' ', '',$foto->getClientOriginalName());
        
                    $nama_file_foto = time()."_".$text_foto;
                    
                    $foto->move(public_path('Reporforium/foto'),$nama_file_foto);
                    $temp[] = [
                        'id_reporforium' => $reporforium->id,
                        'foto' => $nama_file_foto,
                        'nik' => $niks,
                        'nama' => $name,
                    ];
                }
                $i++;
            }
            
            DetailReporforium::insert($temp);

            DB::commit();
            $scan->move(public_path('Reporforium/file'),$nama_file_scan);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Akta PPAT']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
