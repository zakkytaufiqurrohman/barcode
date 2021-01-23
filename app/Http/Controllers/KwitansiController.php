<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kwitansi;
use App\Models\Berkas;
use App\Models\Uraian;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PDF;


class KwitansiController extends Controller
{
    public function index()
    {
        return view('kwitansi.index');
    }
    public function data(Request $request)
    {

        $data = Kwitansi::query();
        return DataTables::eloquent($data)
            ->addColumn('barcode',function ($data) {
                // get kode berkas from table berkas
                $kode = $data->berkas->kode_berkas;
                $kode = str_replace("/", "", $kode);
                $kode =  config('app.url').'/berkas/kwitansi/'.$kode;
                // generate barcode
                $images = \DNS2D::getBarcodePNGPath(strval($kode), 'QRCODE',5,5);
                // get image patch
                $nameImage = str_replace("\\", "", $images);
                $nameImage = str_replace("/barcode", "", $nameImage);
                $url= asset("barcode/$nameImage");

                $barcode = '';
                $barcode .= "<a href='kwitansis/download/$nameImage'><img src=".$url." border='0' width='100' class='img' align='center' />'</a>" ;

                return $barcode;
            })
            ->addColumn('action', function ($data) {
               
                $action = '';
                $action .= "<a href='" . route('kwitansi.print',$data->id_kwitansi) . "' class='btn btn-icon btn-success'><i class='fa fa-print'></i></a>&nbsp;"; 
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' data-id='{$data->id_kwitansi}' onclick='showKwitansi(this);'><i class='fa fa-edit'></i></a>&nbsp;";
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id_kwitansi}' onclick='deleteKwitansi(this);'><i class='fa fa-trash'></i></a>&nbsp;";

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

                $dibuat = $data->berkas->id_user;
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
        // dd($request->jumlah);
        date_default_timezone_set('Asia/Jakarta');
        // $this->validate($request,[
        //      'nomor' => 'required|min:3|max:255',
        //      'tanggal' => 'required',
        //      'pihak1' => 'required|min:3',
        //      'pihak2' => 'required|min:3',
        //      'isi' =>'required|min:3',
        // ],[
        //     'nomor.required'=>'Nomor Tidak Boleh Kosong',
        //     'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
        //     'pihak1.required'=>'Pihak 1 Tidak Boleh Kosong',
        //     'pihak2.required'=>'Pihak 2 Tidak Boleh Kosong',
        //     'isi.required'=>'Isi Tidak Boleh Kosong',
        //     'nomor.min'=>'Nomor minimal 3 character',
        //     'pihak1.min'=>'Pihak 1 minimal 3 character',
        //     'pihak2.min'=>'Pihak 2 minimal 3 character',
        //     'isi.min'=>'Isi minimal 3 character',
        //     ]);
         $passwordStatus = 'OFF';
         if($request->has('password')){
                $passwordStatus= 'ON';
         }
        DB::beginTransaction();
        try{
            $berkas = Berkas::create([
                'tipe_berkas' => 'kwitansi',
                'id_user' => Auth::user()->id_user,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'waktu' => date('H:i:s'),
                'kode_berkas' => str_replace("/", "",bcrypt(date("Y-m-d h:i:sa").rand(10,100))),
                'password_berkas' => bcrypt(12345678),
                'password' => $passwordStatus,
            ]);
            DB::commit();
            if($berkas->id_berkas < 0 || empty($berkas->id_berkas)){
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Gagal simpan ke tabel berkas']);
            }
            $kwitansi = Kwitansi::create([
                'nomor' => $request->nomor,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'terima' => $request->terima,
                'catatan' => $request->catatan,
                'penyetor' => $request->penyetor,
                'mengetahui' => $request->mengetahui,
                'penerima' => $request->penerima,
                'id_berkas' => $berkas->id_berkas,
            ]);
            $uraian = $request->uraian;
            $jumlah = $request->jumlah;

            $uraian_records = [];

            foreach(array_combine($uraian,$jumlah) as $urai => $jml)
            {
                if(! empty([$urai,$jml]))
                {
                    // Get the current time
                    $now = \Carbon\Carbon::now();

                    // Formulate record that will be saved
                    $uraian_records[] = [
                        'id_kwitansi' => $kwitansi->id_kwitansi,
                        'uraian' => $urai,
                        'jumlah' => $jml,
                        'updated_at' => $now,  // remove if not using timestamps
                        'created_at' => $now   // remove if not using timestamps
                    ];
                }
            }           
            Uraian::insert($uraian_records);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan kwitansi']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function show(Request $request)
    {
        $kwitansi = Kwitansi::with('urai')->find($request->id);
        // dd($kwitansi);
        // $uraian = Uraian::find($kwitansi->id_kwitansi);
        // $id_berkas = $kwitansi->id_berkas;
        // // $id_uraian = $uraian->id_kwitansi;
        // $berkas = Berkas::where('id_berkas',$id_berkas)->first()->attributesToArray();
        // $uraian = Uraian::where('id_kwitansi',$uraian)->first()->attributesToArray();
        // $datas = array_merge($kwitansi->attributesToArray(),$berkas,$uraian);
        if (!$kwitansi) {
            return response()->json(['status' => 'error', 'message' => 'kwitansi tidak ditemukan', 'data' => '']);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data daftar kwitansi', 'data' => $kwitansi]);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $kwitansi = Kwitansi::find($request->id);
            $uraian = Uraian::find($kwitansi->id_kwitansi);
            $berkas = Berkas::find($kwitansi->id_berkas);
            if (!$berkas) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Berkas tidak ditemukan.']);
            }
            if (!$kwitansi) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'kwitansi tidak ditemukan.']);
            }
            if (!$uraian) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Uraian tidak ditemukan.']);
            }
            $berkas->delete();
            $kwitansi->delete();
            $uraian->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus kwitansi']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
    
        DB::beginTransaction();
        try{
            
            $data = Kwitansi::find($request->id);
            $data->update([
                'nomor' => $request->nomor,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'terima' => $request->terima,
                'catatan' => $request->catatan,
                'penyetor' => $request->penyetor,
                'mengetahui' => $request->mengetahui,
                'penerima' => $request->penerima,
            ]);
            DB::commit();

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
            
            // uraian
            $uraian = $request->uraian;
            $jumlah = $request->jumlah;
            if(empty($uraian)){
                return response()->json(['status' => 'error', 'message' => 'uraian tidak boleh kosong']);
            }
            
            // delete all 
            $uraians = Uraian::where('id_kwitansi',$request->id);
            if (!empty($uraians)){
                $uraians->delete();
            }
            foreach(array_combine($uraian,$jumlah) as $urai => $jml)
            {
                $uraian_record = [];
                $now = \Carbon\Carbon::now();
                if(! empty([$urai,$jml]))
                {
                    $uraian_record[] = [
                        'id_kwitansi' => $request->id,
                        'uraian' => $urai,
                        'jumlah' => $jml,
                        'updated_at' => $now,  // remove if not using timestamps
                        'created_at' => $now   // remove if not using timestamps
                    ];
                    Uraian::insert($uraian_record);
                    
                }
                
            }
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan kwintansi']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function print($id)
    {
        $data = Kwitansi::with('urai','berkas')->find($id);
        $pdf = PDF::loadview('kwitansi.print',['data'=>$data]);
        return $pdf->stream('kwitansi.pdf');
    }
}
