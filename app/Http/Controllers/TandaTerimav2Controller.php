<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berkas;
use App\Models\Setting;
use App\Models\TandaTerimaV2;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PDF;

class TandaTerimav2Controller extends Controller
{
    public function index()
    {
        return view('tandaterimav2.index');
    }
    public function data(Request $request)
    {

        $data = Tandaterimav2::query();
        $data->orderBy('id_tandaterima','DESC');
        return DataTables::eloquent($data)
            ->addColumn('barcode',function ($data) {
                // get kode berkas from table berkas
                $kode = $data->berkas->kode_berkas;
                $kode = str_replace("/", "", $kode);
                $kode =  config('app.url').'/berkas/tandaterima/'.$kode;
                // generate barcode
                $images = \DNS2D::getBarcodePNGPath(strval($kode), 'QRCODE',5,5);
                // get image patch
                $nameImage = str_replace("\\", "", $images);
                $nameImage = str_replace("/barcode", "", $nameImage);
                $url= asset("barcode/$nameImage");

                $barcode = '';
                $barcode .= "<a href='tanda-terimas/download/$nameImage'><img src=".$url." border='0' width='100' class='img' align='center' />'</a>" ;

                return $barcode;
            })
            ->addColumn('action', function ($data) {
               
                $action = '';
                $action .= "<a href='" . route('tandaterima.print',$data->id_tandaterima) . "' class='btn btn-icon btn-success'><i class='fa fa-print'></i></a>&nbsp;"; 
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' data-id='{$data->id_tandaterima}' onclick='showTandaTerima(this);'><i class='fa fa-edit'></i></a>&nbsp;";
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id_tandaterima}' onclick='deleteTandaTerima(this);'><i class='fa fa-trash'></i></a>&nbsp;";

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

        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
             'terima' => 'required|min:3|max:255',
             'berupa' => 'required|min:3',
             'keperluan' => 'required|min:3',
             'tanggal' => 'required',
             'penerima' => 'required|min:3',
             'penyerah' =>'required|min:3',
        ],[
            'terima.required'=>'Terima Dari Tidak Boleh Kosong',
            'berupa.required'=>'berupa 2 Tidak Boleh Kosong',
            'keperluan.required'=>'keperluan Tidak Boleh Kosong',
            'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            'penerima.required'=>'penerima Tidak Boleh Kosong',
            'penyerah.required'=>'penyerah Tidak Boleh Kosong',

            // 'terima.min'=>'Pihak 1 minimal 3 character',
            // 'berupa.min'=>'Pihak 2 minimal 3 character',
            // 'isi.min'=>'Isi minimal 3 character',
        ]);
         $passwordStatus = 'OFF';
         if($request->has('password')){
                $passwordStatus= 'ON';
         }
        DB::beginTransaction();
        try{
            $berkas = Berkas::create([
                'tipe_berkas' => 'tandaterima',
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
            $data = TandaTerimav2::create([
                'terima' => $request->terima,
                'berupa' => $request->berupa,
                'keperluan' => $request->keperluan,
                'tanggal' => $request->tanggal,
                'penerima' => $request->penerima,
                'penyerah' => $request->penyerah,
                'id_berkas' => $berkas->id_berkas,
            ]);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Tanda Terima']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $tandaTerima = TandaTerimaV2::find($request->id);
            $berkas = Berkas::find($tandaTerima->id_berkas);
            if (!$berkas) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Berkas tidak ditemukan.']);
            }
            if (!$tandaTerima) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Tanda Terima tidak ditemukan.']);
            }

            $berkas->delete();
            $tandaTerima->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus tandaTerima']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function show(Request $request)
    {
        $tandaterima = TandaTerimav2::find($request->id);
        $id_berkas = $tandaterima->id_berkas;
        $berkas = Berkas::where('id_berkas',$id_berkas)->first()->attributesToArray();
        $datas = array_merge($tandaterima->attributesToArray(),$berkas);
        if (!$tandaterima) {
            return response()->json(['status' => 'error', 'message' => 'Tanda Terima tidak ditemukan', 'data' => '']);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data daftar Tanda Terima', 'data' => $datas]);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
             'terima' => 'required|min:3|max:255',
             'berupa' => 'required|min:3',
             'keperluan' => 'required|min:3',
             'tanggal' => 'required',
             'penerima' => 'required|min:3',
             'penyerah' =>'required|min:3',
        ],[
            'terima.required'=>'Terima Dari Tidak Boleh Kosong',
            'berupa.required'=>'berupa 2 Tidak Boleh Kosong',
            'keperluan.required'=>'keperluan Tidak Boleh Kosong',
            'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            'penerima.required'=>'penerima Tidak Boleh Kosong',
            'penyerah.required'=>'penyerah Tidak Boleh Kosong',
        ]);

        DB::beginTransaction();
        try{
            
            $data = TandaTerimav2::find($request->id);
            $data->update([
                'terima' => $request->terima,
                'berupa' => $request->berupa,
                'keperluan' => $request->keperluan,
                'tanggal' =>  \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'penerima' => $request->penerima,
                'penyerah' => $request->penyerah,
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
                'tanggal' =>  \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'password' => $passwordStatus,
            ]);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Tanda Terima']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function print($id)
    {
        $data = TandaTerimav2::find($id);
        $setting = Setting::first();
        $pdf = PDF::loadview('tandaterimav2.print',['data'=>$data,'setting'=>$setting]);
        return $pdf->stream('tandaterima.pdf');
    }
}
