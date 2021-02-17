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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PpatImport;


class PpatController extends Controller
{
    public function index()
    {
        return view('ppat.index');
    }
    public function data(Request $request)
    {

        $data = Ppat::query();
        $data->orderBy('id_ppat','DESC');
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
                $barcode .= "<a href='ppats/download$nameImage'><img src=".$url." border='0' width='100' class='img' align='center' />'</a>" ;

                return $barcode;
            })
            ->addColumn('action', function ($data) {
               
                $action = '';
                $action .= "<a href='" . route('ppat.detail', $data->id_ppat) ."' class='btn btn-icon btn-success'><i class='fa fa-eye'></i></a>&nbsp;";
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
            'no_urut' => 'required|min:3',
            'no_akta' => 'required|min:3',
            'tanggal_akta' => 'required',
            'bentuk_hukum' =>'required|min:3',
            'pihak1' => 'required|min:3',
            'pihak2' => 'required|min:3',
            'nomor_hak' => 'required|min:3',
            'letak_bangunan' => 'required|min:3',
            'luas_tanah' => 'required|min:3',
            'luas_bangunan' => 'required|min:3',
            'harga_transaksi' => 'required|min:3',
            'nop_tahun' =>'required|min:3',
            'nilai_njop' => 'required|min:3',
            'tanggal_ssp' => 'required',
            'nilai_ssp' => 'required|min:3',
            'tanggal_ssb' => 'required',
            'nilai_ssb' => 'required|min:3',
            'keterangan' =>'required|min:3',
            'tgl_masuk_bpn' => 'required',
            'tgl_selesai_bpn' => 'required',
            'tgl_penyerahan_clien' => 'required',
            'no_ktp' => 'required|min:3',
            'alamat' => 'required|min:3',
            'pas_foto' =>'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akad' =>'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'no_urut.required'=>'No Urut Tidak Boleh Kosong',
            'no_akta.required'=>'No Akta Tidak Boleh Kosong',
            'tanggal_akta.required'=>'Tanggal Akta Tidak Boleh Kosong',
            'bentuk_hukum.required'=>'Bentuk Perbuatan Hukum Tidak Boleh Kosong',
            'pihak1.required'=>'Pihak Yang Memberikan Tidak Boleh Kosong',
            'pihak2.required'=>'Pihak Yang Menerima Tidak Boleh Kosong',
            'nomor_hak.required'=>'Nomor Hak Tidak Boleh Kosong',
            'letak_bangunan.required'=>'Letak Tanah Dan Bangunan Tidak Boleh Kosong',
            'luas_tanah.required'=>'Luas Tanah Tidak Boleh Kosong',
            'luas_bangunan.required'=>'Luas Bangunan Tidak Boleh Kosong',
            'harga_transaksi.required'=>'Harga Transaksi Tidak Boleh Kosong',
            'nop_tahun.required'=>'NOP/Tahun Tidak Boleh Kosong',
            'nilai_njop.required'=>'Nilai NJOP Tidak Boleh Kosong',
            'tanggal_ssp.required'=>'Tanggal SSP Tidak Boleh Kosong',
            'nilai_ssp.required'=>'Nilai SSP Tidak Boleh Kosong',
            'tanggal_ssb.required'=>'Tanggal SSB Tidak Boleh Kosong',
            'nilai_ssb.required'=>'Nilai SSB Tidak Boleh Kosong',
            'keterangan.required'=>'Keterangan Tidak Boleh Kosong',
            'tgl_masuk_bpn.required'=>'Tanggal Masuk BPN Tidak Boleh Kosong',
            'tgl_selesai_bpn.required'=>'Tanggal Selesai BPN Tidak Boleh Kosong',
            'tgl_penyerahan_clien.required'=>'Tanggal Penyerahan Clien Tidak Boleh Kosong',
            'no_ktp.required'=>'No KTP Tidak Boleh Kosong',
            'alamat.required'=>'Alamat Tidak Boleh Kosong',
            'pas_foto.required'=>'Pas Foto Tidak Boleh Kosong',
            'foto_akad.required'=>'Fota Akad Tidak Boleh Kosong',

            'no_urut.min'=>'No Urut minimal 3 character',
            'no_akta.min'=>'No Akta minimal 3 character',
            'bentuk_hukum.min'=>'Bentuk Perbuatan Hukum minimal 3 character',
            'pihak1.min'=>'Pihak Yang Memberikan minimal 3 character',
            'pihak2.min'=>'Pihak Yang Menerima minimal 3 character',
            'nomor_hak.min'=>'Nomor Hak minimal 3 character',
            'letak_bangunan.min'=>'Letak Tanah Dan Bangunan minimal 3 character',
            'luas_tanah.min'=>'Luas Tanah minimal 3 character',
            'luas_bangunan.min'=>'Luas Bangunan minimal 3 character',
            'harga_transaksi.min'=>'Harga Transaksi minimal 3 character',
            'nop_tahun.min'=>'NOP/Tahun minimal 3 character',
            'nilai_njop.min'=>'Nilai NJOP minimal 3 character',
            'nilai_ssp.min'=>'Nilai SSP minimal 3 character',
            'nilai_ssb.min'=>'Nilai SSB minimal 3 character',
            'keterangan.min'=>'Keterangan minimal 3 character',
            'no_ktp.min'=>'No KTP minimal 3 character',
            'alamat.min'=>'Alamat minimal 3 character',

            'pas_foto.mimes'=>'Format File Harus Jpg/png',
            'foto_akad.mimes'=>'Format File Harus Jpg/png',

            'pas_foto.max'=>'File Max 2048',
            'foto_akad.max'=>'File Max 2048',
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
            // DB::commit();
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
            DB::commit();
            $file_pas_foto->move(public_path('GambarFotoAkad'),$nama_file_pas_foto);
            $file_foto_akad->move(public_path('GambarPasFoto'),$nama_file_foto_akad);
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
        $this->validate($request,[
            'no_urut' => 'required|min:3',
            'no_akta' => 'required|min:3',
            'tanggal_akta' => 'required',
            'bentuk_hukum' =>'required|min:3',
            'pihak1' => 'required|min:3',
            'pihak2' => 'required|min:3',
            'nomor_hak' => 'required|min:3',
            'letak_bangunan' => 'required|min:3',
            'luas_tanah' => 'required|min:3',
            'luas_bangunan' => 'required',
            'harga_transaksi' => 'required|min:3',
            'nop_tahun' =>'required|min:3',
            // 'nilai_njop' => 'required|min:3',
            'tanggal_ssp' => 'required',
            'nilai_ssp' => 'required|min:3',
            'tanggal_ssb' => 'required',
            'nilai_ssb' => 'required|min:3',
            // 'keterangan' =>'required|min:3',
            'tgl_masuk_bpn' => 'required',
            // 'tgl_selesai_bpn' => 'required',
            // 'tgl_penyerahan_clien' => 'required',
            // 'no_ktp' => 'required|min:3',
            // 'alamat' => 'required|min:3',
            'pas_foto' =>'file|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akad' =>'file|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'no_urut.required'=>'No Urut Tidak Boleh Kosong',
            'no_akta.required'=>'No Akta Tidak Boleh Kosong',
            'tanggal_akta.required'=>'Tanggal Akta Tidak Boleh Kosong',
            'bentuk_hukum.required'=>'Bentuk Perbuatan Hukum Tidak Boleh Kosong',
            'pihak1.required'=>'Pihak Yang Memberikan Tidak Boleh Kosong',
            'pihak2.required'=>'Pihak Yang Menerima Tidak Boleh Kosong',
            'nomor_hak.required'=>'Nomor Hak Tidak Boleh Kosong',
            'letak_bangunan.required'=>'Letak Tanah Dan Bangunan Tidak Boleh Kosong',
            'luas_tanah.required'=>'Luas Tanah Tidak Boleh Kosong',
            'luas_bangunan.required'=>'Luas Bangunan Tidak Boleh Kosong',
            'harga_transaksi.required'=>'Harga Transaksi Tidak Boleh Kosong',
            'nop_tahun.required'=>'NOP/Tahun Tidak Boleh Kosong',
            'nilai_njop.required'=>'Nilai NJOP Tidak Boleh Kosong',
            'tanggal_ssp.required'=>'Tanggal SSP Tidak Boleh Kosong',
            'nilai_ssp.required'=>'Nilai SSP Tidak Boleh Kosong',
            'tanggal_ssb.required'=>'Tanggal SSB Tidak Boleh Kosong',
            'nilai_ssb.required'=>'Nilai SSB Tidak Boleh Kosong',
            'keterangan.required'=>'Keterangan Tidak Boleh Kosong',
            'tgl_masuk_bpn.required'=>'Tanggal Masuk BPN Tidak Boleh Kosong',
            'tgl_selesai_bpn.required'=>'Tanggal Selesai BPN Tidak Boleh Kosong',
            'tgl_penyerahan_clien.required'=>'Tanggal Penyerahan Clien Tidak Boleh Kosong',
            'no_ktp.required'=>'No KTP Tidak Boleh Kosong',
            'alamat.required'=>'Alamat Tidak Boleh Kosong',

            'no_urut.min'=>'No Urut minimal 3 character',
            'no_akta.min'=>'No Akta minimal 3 character',
            'bentuk_hukum.min'=>'Bentuk Perbuatan Hukum minimal 3 character',
            'pihak1.min'=>'Pihak Yang Memberikan minimal 3 character',
            'pihak2.min'=>'Pihak Yang Menerima minimal 3 character',
            'nomor_hak.min'=>'Nomor Hak minimal 3 character',
            'letak_bangunan.min'=>'Letak Tanah Dan Bangunan minimal 3 character',
            'luas_tanah.min'=>'Luas Tanah minimal 3 character',
            'luas_bangunan.min'=>'Luas Bangunan minimal 3 character',
            'harga_transaksi.min'=>'Harga Transaksi minimal 3 character',
            'nop_tahun.min'=>'NOP/Tahun minimal 3 character',
            'nilai_njop.min'=>'Nilai NJOP minimal 3 character',
            'nilai_ssp.min'=>'Nilai SSP minimal 3 character',
            'nilai_ssb.min'=>'Nilai SSB minimal 3 character',
            'keterangan.min'=>'Keterangan minimal 3 character',
            'no_ktp.min'=>'No KTP minimal 3 character',
            'alamat.min'=>'Alamat minimal 3 character',

            'pas_foto.mimes'=>'Format File Harus Jpg/png',
            'foto_akad.mimes'=>'Format File Harus Jpg/png',

            'pas_foto.max'=>'File Max 2048',
            'foto_akad.max'=>'File Max 2048',
            ]);

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
                
                $file_pas_foto->move(public_path('GambarPasFoto'),$nama_file_pas_foto);

                //hapus file lama
                if (file_exists(public_path('GambarPasFoto/').$ppat->pas_foto))
                {
                    $image_path_pas_foto = public_path('GambarPasFoto/').$ppat->pas_foto;

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

                $file_foto_akad->move(public_path('GambarFotoAkad'),$nama_file_foto_akad);

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
            
            // DB::commit();

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

    public function detail(Request $request)
    {
        $ppat = Ppat::find($request->id);
        // dd($ppat);
        return view('ppat.detail',compact('ppat'));
    }

    public function import(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request,[
            'excel' => 'required|mimes:xls,xlsx',
        ]);
        
        DB::beginTransaction();
        try{

            // // menangkap file excel
            // $file = $request->file('excel');
    
            // // membuat nama file unik
            // $nama_file = rand().$file->getClientOriginalName();
    
            // // upload ke folder file_siswa di dalam folder public
            // $file->move(public_path('import/'),$nama_file);
    
            // import data
            $data = Excel::import(new PpatImport,request()->file('excel'));
            if(empty($data->errors)){
                DB::commit();
                return response()->json(['status' => 'success', 'message' =>'berasil di import']);
            }
            else{
                return response()->json(['status' => 'error', 'message' => $data->errors]);
            }
            // DB::commit();
            // return response()->json(['status' => 'success', 'message' => 'Berhasil import data!']);
        } catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function downloadExcel()
    {
        $url=  public_path(). '/Import/ppat.xlsx';
        return \Response::download($url);
    }
}
