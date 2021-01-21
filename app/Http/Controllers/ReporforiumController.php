<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporforium;
use App\Models\DetailReporforium;
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

    public function data(Request $request)
    {

        $data = Reporforium::query();
        return DataTables::eloquent($data)
            ->addColumn('barcode',function ($data) {
                // get kode berkas from table berkas
                $kode = $data->berka->kode_berkas;
                $kode = str_replace("/", "", $kode);
                $kode =  config('app.url').'/berkas/reporforium/'.$kode;
                // generate barcode
                $images = \DNS2D::getBarcodePNGPath(strval($kode), 'QRCODE',5,5);
                // get image patch
                $nameImage = str_replace("\\", "", $images);
                $nameImage = str_replace("/barcode", "", $nameImage);
                $url= asset("barcode/$nameImage");

                $barcode = '';
                $barcode .= "<a href='reporforiums/download/$nameImage'><img src=".$url." border='0' width='100' class='img' align='center' />'</a>" ;

                return $barcode;
            })
            ->addColumn('action', function ($data) {
               
                $action = '';
                $action .= "<a href='" . route('reporforium.detail',$data->id_reporforium) . "' class='btn btn-icon btn-success'><i class='fa fa-info'></i></a>&nbsp;"; 
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' data-id='{$data->id_reporforium}' onclick='showReporforium(this);'><i class='fa fa-edit'></i></a>&nbsp;";
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id_reporforium}' onclick='deleteReporforium(this);'><i class='fa fa-trash'></i></a>&nbsp;";

                return $action;
            })
            ->addColumn('tanggal', function ($data) {
               
                $tanggal = '';
                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data->tanggal)) {
                    $tanggal = \Carbon\Carbon::parse($data->tanggal)->isoFormat('D MMMM Y');
                }
                else if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$data->tanggal)){
                    $tanggal = \Carbon\Carbon::parse($data->tanggal)->isoFormat('D MMMM Y');
                } 
                else {
                    $tanggal = $data->tanggal;
                }
                
                return $tanggal;
            })
            ->addColumn('dibuat', function ($data) {
               
                $dibuat = "";

                $dibuat = $data->berka->id_user;
                $user = User::where('id_user',$dibuat)->first();
                if(empty($user)){
                    return '';
                }
                else{
                    $dibuat = $user->nama_user;  
                    return $dibuat;
                }
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        //validasi
        // untuk foto img / untuk berkas pdf
        $this->validate($request,[
            'foto.*' => 'required|max:2048|mimes:jpeg,jpg,png'
        ]); 
        // untuk foto img / untuk berkas pdf
        $this->validate($request,[
            'berkas' => 'required|max:10000|mimes:pdf'
        ]);
        $passwordStatus = 'OFF';
        if($request->has('password')){
               $passwordStatus= 'ON';
        }
        DB::beginTransaction();
        try{
            $berkas = Berkas::create([
                'tipe_berkas' => 'reporforium',
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
                        'id_reporforium' => $reporforium->id_reporforium,
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
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Reporforium']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function show(Request $request)
    {
        $reporforium = Reporforium::with('detailrepo')->find($request->id);
        if (!$reporforium) {
            return response()->json(['status' => 'error', 'message' => 'reporforium tidak ditemukan', 'data' => '']);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data daftar reporforium', 'data' => $reporforium]);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
    
        DB::beginTransaction();
        try{
            
            $data = Reporforium::find($request->id);
            $data->update([
                'nomor' => $request->nomor,
                'no_bulanan' => $request->no_bulanan,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'sifat_akta' => $request->sifat_akta,
                // 'berkas' => $request->berkas,
                'sk_kemenhumkam' => $request->sk_kemenhumkam,
            ]);

            $id_berkas = $data->id_berkas;
            if($id_berkas == null || empty($id_berkas)){
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => "gagal mendapatkan id"]);
            }
            // update ke berkas jika user update password
            if($request->password == 1) {
                $passwordStatus= 'ON';
            }
            else {
                $passwordStatus= 'OFF';
            }

            $berkas = Berkas::find($id_berkas);
            $berkas->update([
                'id_user' => Auth::user()->id_user,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'password' => $passwordStatus,
            ]);
            
            // detail reporforium
            $nama = $request->nama;
            $nik = $request->nik;
            if(empty($nama)){
                return response()->json(['status' => 'error', 'message' => 'nama tidak boleh kosong']);
            }
            
            // delete all 
            $detail_repo = DetailReporforium::where('id_reporforium',$request->id);
            if (!empty($detail_repo)){

                if (file_exists(public_path('Reporforium/foto/').$detail_repo->foto))
                {
                    $image_path_pas_foto = public_path('Reporforium/foto/').$detail_repo->foto;
                    unlink($image_path_pas_foto);
                }
                $detail_repo->delete();
            }
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
                        'id_reporforium' => $reporforium->id_reporforium,
                        'foto' => $nama_file_foto,
                        'nik' => $niks,
                        'nama' => $name,
                    ];
                }
                $i++;
            }
            
            DetailReporforium::insert($temp);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan kwintansi']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $reporforium = Reporforium::find($request->id);
            $detailreporforium = DetailReporforium::where('id_reporforium',$reporforium->id_reporforium);
            $berkas = Berkas::find($reporforium->id_berkas);
            if (!$berkas) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Berkas tidak ditemukan.']);
            }
            if (!$reporforium) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Reporforium tidak ditemukan.']);
            }
            if (!$detailreporforium) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Detail Reporforium tidak ditemukan.']);
            }
            $berkas->delete();
            $reporforium->delete();
            $detailreporforium->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Reporforium']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function detail($id)
    {
        $reporforium = Reporforium::with('detailrepo')->find($id);
        // return $reporforium;
        if (empty($reporforium)){
            return 'Reporforium not found';
        }
        else {
            return view('reporforium.detail',compact('reporforium'));
        }
    }
}
