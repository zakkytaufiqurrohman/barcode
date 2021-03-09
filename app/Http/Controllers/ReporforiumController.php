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
use PDF;
use App\Imports\ReporforiumImport;
use Maatwebsite\Excel\Facades\Excel;

class ReporforiumController extends Controller
{
    public function index()
    {
        return view('reporforium.index');
    }

    public function data(Request $request)
    {
        $dates = request()->get('date') ?? null;

        $date = explode('&',$dates);

        $data = Reporforium::query();

        if($dates!=null)
            $data = $data->whereBetween('tanggal',$date);
        
        return DataTables::eloquent($data)
            ->addColumn('barcode',function ($data) {
                // get kode berkas from table berkas
                $kode = $data->berka->kode_berkas;
                $kode = str_replace("/", "", $kode);
                $kode =  config('app.url').'/berkas_reporforium/'.$kode;
                // generate barcode
                $images = \DNS2D::getBarcodePNGPath(strval($kode), 'QRCODE',5,5);
                // get image patch
                $nameImage = str_replace("\\", "", $images);
                $nameImage = str_replace("/barcode", "", $nameImage);
                $url= asset("barcode/$nameImage");

                $barcode = '';
                $barcode .= "<a href='reporforiums/download$nameImage'><img src=".$url." border='0' width='100' class='img' align='center' />'</a>" ;

                return $barcode;
            })
            ->addColumn('action', function ($data) {
                $action = '';

                $id_berkas = $data->berka->id_user;
                if ($id_berkas ==  Auth::user()->id_user ||  Auth::user()->level_user == 'Admin' || Auth::user()->level_user == 'Superadmin') {
                    $action .= "<a href='" . route('reporforium.detail',$data->id_reporforium) . "' class='btn btn-icon btn-success'><i class='fa fa-eye'></i></a>&nbsp;"; 
                    $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' data-id='{$data->id_reporforium}' onclick='showReporforium(this);'><i class='fa fa-edit'></i></a>&nbsp;";
                    $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id_reporforium}' onclick='deleteReporforium(this);'><i class='fa fa-trash'></i></a>&nbsp;";
                }
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
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'nomor' => 'required|min:2|max:255',
             'no_bulanan' => 'required|int',
             'tanggal' => 'required|min:2',
             'sifat_akta' => 'required|min:2',
             'sk_kemenhumkam' =>'required|min:2',
        ],[
            'nomor.required'=>'Nomor Tidak Boleh Kosong',
            'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            'no_bulanan.required'=>'No Bulanan Tidak Boleh Kosong',
            'sk_kemenhumkam.required'=>'Sk Kemenkumham Tidak Boleh Kosong',
            'sifat_akta.required'=>'Sifat Akta Tidak Boleh Kosong',

            'nomor.min'=>'Nomor minimal 2 character',
            'no_bulanan.min'=>'No Bulanan minimal 2 character',
            'sk_kemenhumkam.min'=>'Sk Kemenkumham minimal 2 character',
            'sifat_akta.min'=>'Sifat Akta minimal 2 character',
            
        ]);
        //validasi
        // untuk foto img / untuk berkas pdf
        $this->validate($request,[
            'foto.*' => 'required|max:2048|mimes:jpeg,jpg,png'
        ]); 
        // untuk untuk berkas pdf
        $this->validate($request,[
            'berkas' => 'required|max:10000|mimes:pdf'
        ],[
            'berkas.mimes' => 'Format harus pdf'
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
           
            for($i=0;$i<count($nama);$i++){

                $foto = $fotos[$i];
                $text_foto = str_replace(' ', '',$foto->getClientOriginalName());
    
                $nama_file_foto = time()."_".$text_foto;
                
                $foto->move(public_path('Reporforium/foto'),$nama_file_foto);
                $temp[] = [
                    'id_reporforium' => $reporforium->id_reporforium,
                    'foto' => $nama_file_foto,
                    'nik' => $nik[$i],
                    'nama' => $nama[$i],
                ];
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

    public function showDetail(Request $request)
    {
        $detailreporforium = DetailReporforium::where('id_reporforium',$request->id)->get();
        if (!$detailreporforium) {
            return response()->json(['status' => 'error', 'message' => 'reporforium tidak ditemukan', 'data' => '']);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data daftar detail reporforium', 'data' => $detailreporforium, 'id' => $request->id]);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'nomor' => 'required|min:2|max:255',
            'no_bulanan' => 'required|int',
            'tanggal' => 'required|min:2',
            'sifat_akta' => 'required|min:2',
            'sk_kemenhumkam' =>'required|min:2',
       ],[
           'nomor.required'=>'Nomor Tidak Boleh Kosong',
           'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
           'no_bulanan.required'=>'No Bulanan Tidak Boleh Kosong',
           'sk_kemenhumkam.required'=>'Sk Kemenkumham Tidak Boleh Kosong',
           'sifat_akta.required'=>'Sifat Akta Tidak Boleh Kosong',
           
           'nomor.min'=>'Nomor minimal 2 character',
            'no_bulanan.min'=>'No Bulanan minimal 2 character',
            'sk_kemenhumkam.min'=>'Sk Kemenkumham minimal 2 character',
            'sifat_akta.min'=>'Sifat Akta minimal 2 character',
           
       ]);
       // untuk untuk berkas pdf
        $this->validate($request,[
            'berkas' => 'max:10000|mimes:pdf'
        ],[
            'berkas.mimes' => 'Format harus pdf'
        ]);
        // return $request->berkas;
        $nama_file = $request->file_lama;
        if ($request->has('berkas')){
            $scan = $request->berkas;

            $text_scan = str_replace(' ', '',$scan->getClientOriginalName());

            $nama_file = time()."_".$text_scan;
            $scan->move(public_path('Reporforium/file'),$nama_file);
        }        
        DB::beginTransaction();
        try{
            
            $data = Reporforium::find($request->id);
            $data->update([
                'nomor' => $request->nomor,
                'no_bulanan' => $request->no_bulanan,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'sifat_akta' => $request->sifat_akta,
                'berkas' => $nama_file,
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

    public function storeDetail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'nama' => 'required',
            'nik' => 'required|int',
            'foto' => 'required|max:2048|mimes:jpeg,jpg,png',
        ],[
            'nama.required'=>'nama Tidak Boleh Kosong',
            'nik.required'=>'nik Tidak Boleh Kosong',
            'nik.integer' => 'NIK Tidak boleh mengandung huruf/karakter',
            'foto.required'=>'foto Tidak Boleh Kosong',   
            'foto.mimes' => 'Format foto salah, upload foto jpg,jpeg,png',
            'foto.max' => 'Max foto berukuran 2048 Mb'     
        ]);
        
        DB::beginTransaction();
        try{
            
            $id_reporforium = $request->id;
            $foto = $request->foto;
            $text_foto = str_replace(' ', '',$foto->getClientOriginalName());
        
            $nama_file_foto = time()."_".$text_foto;
                    
            DetailReporforium::insert([
                'id_reporforium' => $id_reporforium,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'foto' => $nama_file_foto
            ]);

            DB::commit();
            $foto->move(public_path('Reporforium/foto'),$nama_file_foto);
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah detail reporforium', 'id' => $id_reporforium]);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateDetail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'nama' => 'required',
            'nik' => 'required|int',
            // 'foto' => 'max:2048|mimes:jpeg,jpg,png',
        ],[
            'nama.required'=>'nama Tidak Boleh Kosong',
            'nik.required'=>'nik Tidak Boleh Kosong',
            'nik.integer' => 'NIK Tidak boleh mengandung huruf/karakter',   
            'foto.mimes' => 'Format foto salah, upload foto jpg,jpeg,png',
            // 'foto.max' => 'Max foto berukuran 2048 Mb'     
        ]);

        DB::beginTransaction();
        try{
            
            $data = DetailReporforium::find($request->id);
            $foto_lama = $data->foto;
            $id_reporforium = $data->id_reporforium;
            $namaFoto = $foto_lama;
            if($request->has('foto')){
                $foto = $request->foto;
                $text_foto = str_replace(' ', '',$foto->getClientOriginalName());
        
                $nama_file_foto = time()."_".$text_foto;
                    
                
                if (file_exists(public_path('Reporforium/foto/'.$foto_lama)))
                {
                    unlink(public_path('Reporforium/foto/'.$foto_lama));
                }

                $namaFoto = $nama_file_foto;
                $foto->move(public_path('Reporforium/foto'),$nama_file_foto);
            }
            
            $data->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'foto' => $namaFoto
            ]);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah detail reporforium', 'id' => $id_reporforium]);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroyDetail(Request $request)
    {
        DB::beginTransaction();
        try {
            $detailreporforium = DetailReporforium::find($request->id);
            if (!$detailreporforium) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Detail Reporforium tidak ditemukan.']);
            }
            $id_reporforium = $detailreporforium->id_reporforium;
            if (file_exists(public_path('Reporforium/foto/'.$detailreporforium->foto)))
            {
                unlink(public_path('Reporforium/foto/'.$detailreporforium->foto));
            }
            $detailreporforium->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Detail Reporforium', 'id' => $id_reporforium]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function download($filepath)
    {   
        $url=  public_path(). '/barcode/'. $filepath;
        return \Response::download($url);
    }

    public function print($dates)
    {
        $dates = $dates ?? null;

        $date = explode('&',$dates);
        $reporforiums = Reporforium::with('detailrepo')->whereBetween('tanggal',$date)->get();
    
        $pdf = PDF::loadview('reporforium.print',['reporforiums'=>$reporforiums,'date'=> $date])->setPaper('a4', 'landscape');
        return $pdf->stream('reporforium.pdf');
    }

    public function import(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'excel' => 'required|mimes:xls,xlsx',
        ]);
        
        DB::beginTransaction();
        try{
            // import data
            $data = Excel::import(new ReporforiumImport, request()->file('excel'));
            if(empty($data->errors)){
                DB::commit();
                return response()->json(['status' => 'success', 'message' =>'berasil di import']);
            }
            else{
                return response()->json(['status' => 'error', 'message' => $data->errors]);
            }
            
           
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function downloadExcel()
    {
        $url=  public_path(). '/import/reporforium.xlsx';
        return \Response::download($url);
    }
}
