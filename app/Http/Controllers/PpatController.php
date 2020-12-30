<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppat;
use App\Models\Berkas;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PpatController extends Controller
{
    public function index()
    {
        return view('ppat.index');
    }
    public function data(Request $request)
    {

        $data = Ppat::query();
        return DataTables::eloquent($data)
            ->addColumn('barcode',function ($data) {
                // get kode berkas from table berkas
                $kode = $data->berkas->kode_berkas;
                $kode = str_replace("/", "", $kode);
                $kode =  config('app.url').'/berkas/ppat/'.$kode;
                // generate barcode
                $images = \DNS2D::getBarcodePNGPath(strval($kode), 'QRCODE',5,5);
                // get image patch
                $nameImage = str_replace("\\", "", $images);
                $nameImage = str_replace("/barcode", "", $nameImage);
                $url= asset("barcode/$nameImage");

                $barcode = '';
                $barcode .= "<a href='ppats/download/$nameImage'><img src=".$url." border='0' width='100' class='img' align='center' />'</a>" ;

                return $barcode;
            })
            ->addColumn('action', function ($data) {
               
                $action = '';
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' data-id='{$data->id_ppat}' onclick='showPpat(this);'><i class='fa fa-edit'></i></a>&nbsp;";
                $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id_ppat}' onclick='deletePpat(this);'><i class='fa fa-trash'></i></a>&nbsp;";

                return $action;
            })
            ->addColumn('tanggal_akta', function ($data) {
               
                $tanggal_akta = '';
                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data->tanggal_akta)) {
                    $tanggal_akta = \Carbon\Carbon::parse($data->tanggal_akta)->isoFormat('D MMMM Y');
                }
                else if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$data->tanggal_akta)){
                    $tanggal_akta = \Carbon\Carbon::parse($data->tanggal_akta)->isoFormat('D MMMM Y');
                } 
                else {
                    $tanggal_akta = $data->tanggal_akta;
                }
                
                return $tanggal_akta;
            })
            ->addColumn('tanggal_ssp', function ($data) {
               
                $tanggal_ssp = '';
                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data->tanggal_ssp)) {
                    $tanggal_ssp = \Carbon\Carbon::parse($data->tanggal_ssp)->isoFormat('D MMMM Y');
                }
                else if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$data->tanggal_ssp)){
                    $tanggal_ssp = \Carbon\Carbon::parse($data->tanggal_ssp)->isoFormat('D MMMM Y');
                } 
                else {
                    $tanggal_ssp = $data->tanggal_ssp;
                }
                
                return $tanggal_ssp;
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
        // dd($request->all());
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'no_urut' => 'required',
            'no_akta' => 'required',
            'tanggal_akta' => 'required',
            'bentuk_hukum' =>'required',
            'pihak1' => 'required',
            'pihak2' => 'required',
            'nomor_hak' => 'required',
            'letak_bangunan' => 'required',
            'luas_tanah' => 'required',
            'luas_bangunan' => 'required',
            'harga_transaksi' => 'required',
            'nop_tahun' =>'required',
            'nilai_njop' => 'required',
            'tanggal_ssp' => 'required',
            'nilai_ssp' => 'required',
            'tanggal_ssb' => 'required',
            'nilai_ssb' => 'required',
            'keterangan' =>'required',
            'tgl_masuk_bpn' => 'required',
            'tgl_selesai_bpn' => 'required',
            'tgl_penyerahan_clien' => 'required',
            'no_ktp' => 'required',
            'alamat' => 'required',
            'pas_foto' =>'required|mimes:jpg,png',
            'foto_akad' =>'required|mimes:jpg,png',
        ],[
            // 'judul.required'=>'Judul Tidak Boleh Kosong',
            // 'nomor.required'=>'Nomor Tidak Boleh Kosong',
            // 'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            // 'pihak1.required'=>'Pihak 1 Tidak Boleh Kosong',
            // 'pihak2.required'=>'Pihak 2 Tidak Boleh Kosong',
            // 'objek.required'=>'objek Tidak Boleh Kosong',
            // 'judul.min'=>'Judul minimal 3 character',
            // 'nomor.min'=>'Nomor minimal 3 character',
            // 'pihak1.min'=>'Pihak 1 minimal 3 character',
            // 'pihak2.min'=>'Pihak 2 minimal 3 character',
            // 'objek.min'=>'objek minimal 3 character',
            ]);
         $passwordStatus = 'OFF';
         if($request->has('password')){
                $passwordStatus= 'ON';
         }
        DB::beginTransaction();
        try{
            $berkas = Berkas::create([
                'tipe_berkas' => 'aktappat',
                'id_user' => Auth::user()->id_user,
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
                'waktu' => date('H:i:s'),
                'kode_berkas' => bcrypt(date("Y-m-d h:i:sa").rand(10,100)),
                'password_berkas' => bcrypt(12345678),
                'password' => $passwordStatus,
            ]);
            DB::commit();
            if($berkas->id_berkas < 0 || empty($berkas->id_berkas)){
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Gagal simpan ke tabel berkas']);
            }
            $file_pas_foto = $request->pas_foto;
            $file_foto_akad = $request->foto_akad;

            $text_pas_foto = str_replace(' ', '',$file_pas_foto->getClientOriginalName());
            $text_foto_akad = str_replace(' ', '',$file_foto_akad->getClientOriginalName());

            $nama_file_pas_foto = time()."_".$text_pas_foto;
            $nama_file_foto_akad = time()."_".$text_foto_akad;
            //hapus file lama
            
            $file_pas_foto->move(public_path('GambarFotoAkad'),$nama_file_pas_foto);
            $file_foto_akad->move(public_path('GambarPasFoto'),$nama_file_foto_akad);

            $update = Ppat::find($request->id);
            if(empty($update)){
                Ppat::create([
                    'pas_foto' => $nama_file_pas_foto,
                    'foto_akad' => $nama_file_foto_akad,
                    'no_urut' => $request->no_urut,
                    'no_akta' => $request->no_akta,
                    'tanggal_akta' => \Carbon\Carbon::parse($request->tanggal_akta)->format('Y-m-d'),
                    'bentuk_hukum' => $request->bentuk_hukum,
                    'pihak1' => $request->pihak1,
                    'pihak2' => $request->pihak2,
                    'nomor_hak' => $request->nomor_hak,
                    'letak_bangunan' => $request->letak_bangunan,
                    'luas_tanah' => $request->luas_tanah,
                    'luas_bangunan' => $request->luas_bangunan,
                    'harga_transaksi' => $request->harga_transaksi,
                    'nop_tahun' => $request->nop_tahun,
                    'nilai_njop' => $request->nilai_njop,
                    'tanggal_ssp' => \Carbon\Carbon::parse($request->tanggal_ssp)->format('Y-m-d'),
                    'nilai_ssp' => $request->nilai_ssp,
                    'tanggal_ssb' => \Carbon\Carbon::parse($request->tanggal_ssb)->format('Y-m-d'),
                    'nilai_ssb' => $request->nilai_ssb,
                    'keterangan' => $request->keterangan,
                    'tgl_masuk_bpn' => \Carbon\Carbon::parse($request->tgl_masuk_bpn)->format('Y-m-d'),
                    'tgl_selesai_bpn' => \Carbon\Carbon::parse($request->tgl_selesai_bpn)->format('Y-m-d'),
                    'tgl_penyerahan_clien' => \Carbon\Carbon::parse($request->tgl_penyerahan_clien)->format('Y-m-d'),
                    'no_ktp' => $request->no_ktp,
                    'alamat' => $request->alamat,
                    'id_berkas' => $berkas->id_berkas,

                ]);
            }
            else {
                // if (file_exists(public_path('settings/').$update->header))
                // {
                    $image_path_pas_foto = public_path('GambarFotoAkad/').$update->pas_foto;
                    $image_path_foto_akad = public_path('GambarPasFoto/').$update->foto_akad;

                    unlink($image_path_pas_foto);
                    unlink($image_path_foto_akad);
                // }
                $update->update([
                    'pas_foto' => $nama_file_pas_foto,
                    'foto_akad' => $nama_file_foto_akad,
                    'no_urut' => $request->no_urut,
                    'no_akta' => $request->no_akta,
                    'tanggal_akta' => \Carbon\Carbon::parse($request->tanggal_akta)->format('Y-m-d'),
                    'bentuk_hukum' => $request->bentuk_hukum,
                    'pihak1' => $request->pihak1,
                    'pihak2' => $request->pihak2,
                    'nomor_hak' => $request->nomor_hak,
                    'letak_bangunan' => $request->letak_bangunan,
                    'luas_tanah' => $request->luas_tanah,
                    'luas_bangunan' => $request->luas_bangunan,
                    'harga_transaksi' => $request->harga_transaksi,
                    'nop_tahun' => $request->nop_tahun,
                    'nilai_njop' => $request->nilai_njop,
                    'tanggal_ssp' => \Carbon\Carbon::parse($request->tanggal_ssp)->format('Y-m-d'),
                    'nilai_ssp' => $request->nilai_ssp,
                    'tanggal_ssb' => \Carbon\Carbon::parse($request->tanggal_ssb)->format('Y-m-d'),
                    'nilai_ssb' => $request->nilai_ssb,
                    'keterangan' => $request->keterangan,
                    'tgl_masuk_bpn' => \Carbon\Carbon::parse($request->tgl_masuk_bpn)->format('Y-m-d'),
                    'tgl_selesai_bpn' => \Carbon\Carbon::parse($request->tgl_selesai_bpn)->format('Y-m-d'),
                    'tgl_penyerahan_clien' => \Carbon\Carbon::parse($request->tgl_penyerahan_clien)->format('Y-m-d'),
                    'no_ktp' => $request->no_ktp,
                    'alamat' => $request->alamat,
                ]);
               
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Akta PPAT']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function show(Request $request)
    {
        $ppat = Ppat::find($request->id);
        $id_berkas = $ppat->id_berkas;
        $berkas = Berkas::where('id_berkas',$id_berkas)->first()->attributesToArray();
        $datas = array_merge($ppat->attributesToArray(),$berkas);
        if (!$ppat) {
            return response()->json(['status' => 'error', 'message' => 'PPAT tidak ditemukan', 'data' => '']);
        }

        return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data daftar PPAT', 'data' => $datas]);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        // $this->validate($request,[
        //     'judul' => 'required|min:3',
        //     'nomor' => 'required|min:3|max:255',
        //     'tanggal' => 'required',
        //     'pihak1' => 'required|min:3',
        //     'pihak2' => 'required|min:3',
        //     'objek' =>'required|min:3',
        // ],[
        //     'judul.required'=>'Judul Tidak Boleh Kosong',
        //     'nomor.required'=>'Nomor Tidak Boleh Kosong',
        //     'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
        //     'pihak1.required'=>'Pihak 1 Tidak Boleh Kosong',
        //     'pihak2.required'=>'Pihak 2 Tidak Boleh Kosong',
        //     'objek.required'=>'objek Tidak Boleh Kosong',
        //     'judul.min'=>'Judul minimal 3 character',
        //     'nomor.min'=>'Nomor minimal 3 character',
        //     'pihak1.min'=>'Pihak 1 minimal 3 character',
        //     'pihak2.min'=>'Pihak 2 minimal 3 character',
        //     'objek.min'=>'objek minimal 3 character',
        //     ]);

        DB::beginTransaction();
        try{
            $ppat=Ppat::findOrFail($request->id);

            if(empty($request->file(['pas_foto']))){
                $nama_file_pas_foto = $ppat->pas_foto;
            }
            else {
                $file_pas_foto = $request->pas_foto;

                $text_pas_foto = str_replace(' ', '',$file_pas_foto->getClientOriginalName());

                $nama_file_pas_foto = time()."_".$text_pas_foto;                
                
                $file_pas_foto->move(public_path('GambarFotoAkad'),$nama_file_pas_foto);

                //hapus file lama
                if (file_exists(public_path('GambarFotoAkad/').$ppat->pas_foto))
                {
                    $image_path_pas_foto = public_path('GambarFotoAkad/').$ppat->pas_foto;

                    unlink($image_path_pas_foto);
                }
            }
            if (empty($request->file(['foto_akad']))){
                $nama_file_foto_akad = $ppat->foto_akad;
            }
            else{
                $file_foto_akad = $request->foto_akad;
    
                $text_foto_akad = str_replace(' ', '',$file_foto_akad->getClientOriginalName());
    
                $nama_file_foto_akad = time()."_".$text_foto_akad;

                $file_foto_akad->move(public_path('GambarPasFoto'),$nama_file_foto_akad);

                if (file_exists(public_path('GambarFotoAkad/').$ppat->foto_akad))
                {
                    $image_path_pas_foto = public_path('GambarFotoAkad/').$ppat->foto_akad;

                    unlink($image_path_pas_foto);
                }
            }

            $update = Ppat::find($request->id);
            $update->update([
                'pas_foto' => $nama_file_pas_foto,
                'foto_akad' => $nama_file_foto_akad,
                'no_urut' => $request->no_urut,
                'no_akta' => $request->no_akta,
                'tanggal_akta' => \Carbon\Carbon::parse($request->tanggal_akta)->format('Y-m-d'),
                'bentuk_hukum' => $request->bentuk_hukum,
                'pihak1' => $request->pihak1,
                'pihak2' => $request->pihak2,
                'nomor_hak' => $request->nomor_hak,
                'letak_bangunan' => $request->letak_bangunan,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'harga_transaksi' => $request->harga_transaksi,
                'nop_tahun' => $request->nop_tahun,
                'nilai_njop' => $request->nilai_njop,
                'tanggal_ssp' => \Carbon\Carbon::parse($request->tanggal_ssp)->format('Y-m-d'),
                'nilai_ssp' => $request->nilai_ssp,
                'tanggal_ssb' => \Carbon\Carbon::parse($request->tanggal_ssb)->format('Y-m-d'),
                'nilai_ssb' => $request->nilai_ssb,
                'keterangan' => $request->keterangan,
                'tgl_masuk_bpn' => \Carbon\Carbon::parse($request->tgl_masuk_bpn)->format('Y-m-d'),
                'tgl_selesai_bpn' => \Carbon\Carbon::parse($request->tgl_selesai_bpn)->format('Y-m-d'),
                'tgl_penyerahan_clien' => \Carbon\Carbon::parse($request->tgl_penyerahan_clien)->format('Y-m-d'),
                'no_ktp' => $request->no_ktp,
                'alamat' => $request->alamat,
            ]);
            
            DB::commit();

            $id_berkas = $update->id_berkas;
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
            return response()->json(['status' => 'success', 'message' => 'Berhasil Update Akta PPAT']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $ppat = Ppat::find($request->id);
            $berkas = Berkas::find($ppat->id_berkas);
            if (!$berkas) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Berkas tidak ditemukan.']);
            }
            if (!$ppat) {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'PPAT tidak ditemukan.']);
            }
            $berkas->delete();
            $ppat->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Akta PPAT']);
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
}
