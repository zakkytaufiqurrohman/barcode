<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktaNotaris;
use App\Models\Berkas;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AktaNotarisController extends Controller
{
    public function index()
    {
        return view('akta-notaris.index');
    }
    public function data(Request $request)
    {
        $data = AktaNotaris::query();
        $data->orderBy('id_aktanotaris','DESC');
        
        return DataTables::eloquent($data)
            ->addColumn('barcode',function ($data) {
                // get kode berkas from table berkas
                $kode = $data->berkas->kode_berkas;
                $kode = str_replace("/", "", $kode);
                $kode =  config('app.url').'/berkas/aktaNotaris/'.$kode;
                // generate barcode
                $images = \DNS2D::getBarcodePNGPath(strval($kode), 'QRCODE',5,5);
                // get image patch
                $nameImage = str_replace("\\", "", $images);
                $nameImage = str_replace("/barcode", "", $nameImage);
                $url= asset("barcode/$nameImage");

                $barcode = '';
                $barcode .= "<a href='akta-notariss/download$nameImage'><img src=".$url." border='0' width='100' class='img' align='center' />'</a>" ;

                return $barcode;
            })
            ->addColumn('action', function ($data) {
               
                $action = '';
                $id_berkas = $data->berkas->id_user;
                if ($id_berkas ==  Auth::user()->id_user ||  Auth::user()->level_user == 'Admin' || Auth::user()->level_user == 'Superadmin') {
                    $action .= "<a href='" . route('akta-notaris.detail', $data->id_aktanotaris) ."' class='btn btn-icon btn-success'><i class='fa fa-eye'></i></a>&nbsp;";
                    $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' data-id='{$data->id_aktanotaris}' onclick='showAktaNotaris(this);'><i class='fa fa-edit'></i></a>&nbsp;";
                    $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id_aktanotaris}' onclick='deleteAktaNotaris(this);'><i class='fa fa-trash'></i></a>&nbsp;";
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
            ->addColumn('isi', function ($data) {
               
                $isi = substr($data->isi,0,25);
                $isi .= "...";
                return $isi;
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'judul' => 'required|min:2',
             'nomor' => 'required|min:2|max:255',
             'tanggal' => 'required',
             'pihak1' => 'required|min:2',
             'pihak2' => 'required|min:2',
             'isi' =>'required|min:2',
        ],[
            'judul.required'=>'Judul Tidak Boleh Kosong',
            'nomor.required'=>'Nomor Tidak Boleh Kosong',
            'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            'pihak1.required'=>'Pihak 1 Tidak Boleh Kosong',
            'pihak2.required'=>'Pihak 2 Tidak Boleh Kosong',
            'isi.required'=>'isi Tidak Boleh Kosong',
            'judul.min'=>'Judul minimal 2 character',
            'nomor.min'=>'Nomor minimal 2 character',
            'pihak1.min'=>'Pihak 1 minimal 2 character',
            'pihak2.min'=>'Pihak 2 minimal 2 character',
            'isi.min'=>'isi minimal 2 character',
            ]);
         $passwordStatus = 'OFF';
         if($request->has('password')){
                $passwordStatus= 'ON';
         }
        DB::beginTransaction();
        try{
            $berkas = Berkas::create([
                'tipe_berkas' => 'aktanotaris',
                'id_user' => Auth::user()->id_user,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'waktu' => date('H:i:s'),
                'kode_berkas' => str_replace("/", "", bcrypt(date("Y-m-d h:i:sa").rand(10,100))),
                'password_berkas' => bcrypt(12345678),
                'password' => $passwordStatus,
            ]);
            DB::commit();
            if($berkas->id_berkas < 0 || empty($berkas->id_berkas)){
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Gagal simpan ke tabel berkas']);
            }
            $data = AktaNotaris::create([
                'judul' => $request->judul,
                'nomor' => $request->nomor,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'pihak1' => $request->pihak1,
                'pihak2' => $request->pihak2,
                'isi' => $request->isi,
                'id_berkas' => $berkas->id_berkas,
            ]);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Akta Notaris']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
        
    }
    public function show(Request $request)
    {
        $aktanotaris = AktaNotaris::find($request->id);
        $id_berkas = $aktanotaris->id_berkas;
        $berkas = Berkas::where('id_berkas',$id_berkas)->first()->attributesToArray();
        $datas = array_merge($aktanotaris->attributesToArray(),$berkas);
        if (!$aktanotaris) {
            return response()->json(['status' => 'error', 'message' => 'Akta Notaris tidak ditemukan', 'data' => '']);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data daftar Akta Notaris', 'data' => $datas]);
    }
    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'judul' => 'required|min:2',
            'nomor' => 'required|min:2|max:255',
            'tanggal' => 'required',
            'pihak1' => 'required|min:2',
            'pihak2' => 'required|min:2',
            'isi' =>'required|min:2',
        ],[
            'judul.required'=>'Judul Tidak Boleh Kosong',
            'nomor.required'=>'Nomor Tidak Boleh Kosong',
            'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            'pihak1.required'=>'Pihak 1 Tidak Boleh Kosong',
            'pihak2.required'=>'Pihak 2 Tidak Boleh Kosong',
            'isi.required'=>'isi Tidak Boleh Kosong',
            'judul.min'=>'Judul minimal 2 character',
            'nomor.min'=>'Nomor minimal 2 character',
            'pihak1.min'=>'Pihak 1 minimal 2 character',
            'pihak2.min'=>'Pihak 2 minimal 2 character',
            'isi.min'=>'isi minimal 2 character',
            ]);

        DB::beginTransaction();
        try{
            
            $data = AktaNotaris::find($request->id);
            $data->update([
                'judul' => $request->judul,
                'nomor' => $request->nomor,
                'tanggal' =>  \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'pihak1' => $request->pihak1,
                'pihak2' => $request->pihak2,
                'isi' => $request->isi,
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
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Akta PPAT']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $aktanotaris = AktaNotaris::find($request->id);
            $berkas = Berkas::find($aktanotaris->id_berkas);
            if (!$berkas) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Berkas tidak ditemukan.']);
            }
            if (!$aktanotaris) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Akta Notaris tidak ditemukan.']);
            }
            $berkas->delete();
            $aktanotaris->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Akta Notaris']);
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

    public function detail(Request $request)
    {
        $notaris = AktaNotaris::find($request->id);
        return view('akta-notaris.detail',compact('notaris'));
    }
}
