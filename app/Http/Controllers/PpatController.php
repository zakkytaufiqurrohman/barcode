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
                'tipe_berkas' => 'ppat',
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
            $will_insert = $request->except(['pas_foto', '_token' ,'foto_akad', 'id_berkas','tanggal_akta',
            'tanggal_ssp','tanggal_ssb','tgl_masuk_bpn','tgl_selesai_bpn','tgl_penyerahan_clien']);
            if($request->hasFile('pas_foto','foto_akad')){

            $pas_ft = $request->pas_foto;
            $ft_akad = $request->foto_akad;
            $idberkas = $berkas->id_berkas;
            $tanggal_akta = \Carbon\Carbon::parse($request->tanggal_akta)->format('Y-m-d');
            $tanggal_ssp = \Carbon\Carbon::parse($request->tanggal_ssp)->format('Y-m-d');
            $tanggal_ssb = \Carbon\Carbon::parse($request->tanggal_ssb)->format('Y-m-d');
            $tgl_masuk_bpn = \Carbon\Carbon::parse($request->tgl_masuk_bpn)->format('Y-m-d');
            $tgl_selesai_bpn = \Carbon\Carbon::parse($request->tgl_selesai_bpn)->format('Y-m-d');
            $tgl_penyerahan_clien = \Carbon\Carbon::parse($request->tgl_penyerahan_clien)->format('Y-m-d');


            $nama_pasfoto = $pas_ft->getClientOriginalName();
            $nama_ftakad = $ft_akad->getClientOriginalName();

                $pas_ft->move(public_path().'/GambarPasFoto', $nama_pasfoto);
                $ft_akad->move(public_path().'/GambarFotoAkad', $nama_ftakad);

                $will_insert['pas_foto'] = $pas_ft;
                $will_insert['foto_akad'] = $ft_akad;
                $will_insert['id_berkas'] = $idberkas;
                $will_insert['tanggal_akta'] = $tanggal_akta;
                $will_insert['tanggal_ssp'] = $tanggal_ssp;
                $will_insert['tanggal_ssb'] = $tanggal_ssb;
                $will_insert['tgl_masuk_bpn'] = $tgl_masuk_bpn;
                $will_insert['tgl_selesai_bpn'] = $tgl_selesai_bpn;
                $will_insert['tgl_penyerahan_clien'] = $tgl_penyerahan_clien;


            }
            Ppat::create($will_insert);
            // $pas_ft = $request->pas_foto;
            // $ft_akad = $request->foto_akad;

            // $nama_pasfoto = $pas_ft->getClientOriginalName();
            // $nama_ftakad = $ft_akad->getClientOriginalName();

            //     $pasft_upload = new Ppat;
            //     $pasft_upload->pas_foto = $nama_pasfoto;
            //     $pasft_upload->foto_akad = $nama_ftakad;
               
            //     $pas_ft->move(public_path().'/GambarPasFoto', $nama_pasfoto);
            //     $ft_akad->move(public_path().'/GambarFotoAkad', $nama_ftakad);

            //     $pasft_upload->save();
            // $data = Ppat::create([
            //     'no_urut' => $request->no_urut,
            //     'no_akta' => $request->no_akta,
            //     'tanggal_akta' => \Carbon\Carbon::parse($request->tanggal_akta)->format('Y-m-d'),
            //     'bentuk_hukum' => $request->bentuk_hukum,
            //     'pihak1' => $request->pihak1,
            //     'pihak2' => $request->pihak2,
            //     'nomor_hak' => $berkas->nomor_hak,
            //     'letak_bangunan' => $request->letak_bangunan,
            //     'luas_tanah' => $request->luas_tanah,
            //     'luas_bangunan' => $request->luas_bangunan,
            //     'harga_transaksi' => $request->harga_transaksi,
            //     'nop_tahun' => $request->nop_tahun,
            //     'nilai_njop' => $berkas->nilai_njop,
            //     'tanggal_ssp' => \Carbon\Carbon::parse($request->tanggal_ssp)->format('Y-m-d'),
            //     'nilai_ssp' => $request->nilai_ssp,
            //     'tanggal_ssb' => \Carbon\Carbon::parse($request->tanggal_ssb)->format('Y-m-d'),
            //     'nilai_ssb' => $request->nilai_ssb,
            //     'keterangan' => $request->keterangan,
            //     'tgl_masuk_bpn' => \Carbon\Carbon::parse($request->tgl_masuk_bpn)->format('Y-m-d'),
            //     'tgl_selesai_bpn' => \Carbon\Carbon::parse($request->tgl_selesai_bpn)->format('Y-m-d'),
            //     'tgl_penyerahan_clien' => \Carbon\Carbon::parse($request->tgl_penyerahan_clien)->format('Y-m-d'),
            //     'no_ktp' => $request->no_ktp,
            //     'alamat' => $berkas->alamat,
            //     'id_berkas' => $berkas->id_berkas,
                
            // ]);
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
        // dd($request->all());
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
            $ppat = Ppat::find($request->id);
            // $will_update = $request->except(['pas_foto', '_token' ,'_method' ,'foto_akad','tanggal_akta',
            // 'tanggal_ssp','tanggal_ssb','tgl_masuk_bpn','tgl_selesai_bpn','tgl_penyerahan_clien']);
            if($request->file != ''){        
                $path = public_path().'/GambarPasFoto';
      
                //code for remove old file
                if($ppat->file != ''  && $ppat->file != null){
                     $file_old = $path.$ppat->file;
                     unlink($file_old);
                }
      
                //upload new file
                $file = $request->file;
                $filename = $file->getClientOriginalName();
                $file->move($path, $filename);
            $ppat->update(['pas_foto' => $pas_ft]);
            $ppat->update(['foto_akad' => $ft_akad]);
            }
            $will_update = new Ppat;
            $will_update->no_urut=$request->no_urut;
            $will_update->no_akta=$request->no_akta;
            $will_update->tanggal_akta= \Carbon\Carbon::parse($request->tanggal_akta)->format('Y-m-d');
            $will_update->bentuk_hukum=$request->bentuk_hukum;
            $will_update->pihak1=$request->pihak1;
            $will_update->pihak2=$request->pihak2;
            $will_update->nomor_hak=$request->nomor_hak;
            $will_update->letak_bangunan=$request->letak_bangunan;
            $will_update->luas_tanah=$request->luas_tanah;
            $will_update->luas_bangunan=$request->luas_bangunan;
            $will_update->harga_transaksi=$request->harga_transaksi;
            $will_update->nop_tahun=$request->nop_tahun;
            $will_update->nilai_njop=$request->nilai_njop;
            $will_update->tanggal_ssp= \Carbon\Carbon::parse($request->tanggal_ssp)->format('Y-m-d');
            $will_update->nilai_ssp=$request->nilai_ssp;
            $will_update->tanggal_ssb=$tanggal_ssb = \Carbon\Carbon::parse($request->tanggal_ssb)->format('Y-m-d');
            $will_update->nilai_ssb=$request->nilai_ssb;
            $will_update->keterangan=$request->keterangan;
            $will_update->tgl_masuk_bpn= \Carbon\Carbon::parse($request->tgl_masuk_bpn)->format('Y-m-d');
            $will_update->tgl_selesai_bpn= \Carbon\Carbon::parse($request->tgl_selesai_bpn)->format('Y-m-d');
            $will_update->tgl_penyerahan_clien= \Carbon\Carbon::parse($request->tgl_penyerahan_clien)->format('Y-m-d');
            $will_update->no_ktp=$request->no_ktp;
            $will_update->alamat=$request->alamat;

            $will_update->save();
            dd($will_update->all());
            // $data = Ppat::find($request->id);
            // $data->update($will_update);
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
