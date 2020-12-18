<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waarmeking;
use App\Models\Berkas;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\FinanceSatu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class WaarmekingController extends Controller
{
    public function index()
    {
        return view('waarmeking.index');
    }

    public function create()
    {
        return view('waarmeking.create');
    }

    public function edit($id)
    {
        $berkas = Waarmeking::find($id);
        // dd($berkas);
        return view('waarmeking.edit', compact('berkas'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
       $this->validate($request,[
            'nomor' => 'required|min:3|max:255',
            'tanggal' => 'required',
            'pihak1' => 'required|min:3',
            'pihak2' => 'required|min:3',
            'isi' =>'required|min:3',
       ],[
            'nomor.required'=>'Nomor Tidak Boleh Kosong',
            'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            'pihak1.required'=>'Pihak 1 Tidak Boleh Kosong',
            'pihak2.required'=>'Pihak 2 Tidak Boleh Kosong',
            'isi.required'=>'Isi Tidak Boleh Kosong',
            ]);
        $passwordStatus = 'OFF';
        if($request->has('password')){
            $passwordStatus= 'ON';
        }
        $berkas = Berkas::create([
            'tipe_berkas' => 'waarmeking',
            'id_user' => '1',
            'tanggal' => \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d'),
            'waktu' => date('H:i:s'),
            'kode_berkas' => bcrypt(12345678),
            'password_berkas' => bcrypt(12345678),

            'password' => $passwordStatus,
        ]);
        // $berkas = Berkas::where('tipeBerkas','Waarmeking')->where('id_user','1')->orderBy
        
        $data = Waarmeking::create([
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal,
            'pihak1' => $request->pihak1,
            'pihak2' => $request->pihak2,
            'isi' => $request->isi,
            'id_berkas' => $berkas->id,
            ]);

        // dd($data);
        return redirect('waarmekings');
    }

    public function update(Request $request,$id)
    {
        // date_default_timezone_set('Asia/Jakarta');
       $this->validate($request,[
            'nomor' => 'required|min:3|max:255',
            'tanggal' => 'required',
            'pihak1' => 'required|min:3',
            'pihak2' => 'required|min:3',
            'isi' =>'required|min:3',
       ],[
            'nomor.required'=>'Nomor Tidak Boleh Kosong',
            'tanggal.required'=>'Tanggal Tidak Boleh Kosong',
            'pihak1.required'=>'Pihak 1 Tidak Boleh Kosong',
            'pihak2.required'=>'Pihak 2 Tidak Boleh Kosong',
            'isi.required'=>'Isi Tidak Boleh Kosong',
            ]);
        $passwordStatus = 'OFF';
        if($request->has('password')){
            $passwordStatus= 'ON';
        }
        $berkas = Berkas::first();
        $data = Waarmeking::find($id);
        $data->update([
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal,
            'pihak1' => $request->pihak1,
            'pihak2' => $request->pihak2,
            'isi' => $request->isi,
            'id_berkas' => $berkas->id_berkas,
        ]);
        // dd($data);
        return redirect('waarmekings');
    }

    public function destroy(Request $request)
    {
        $corpu = Waarmeking::find($request->id);
        // $corpu->delete();
        dd($corpu);
        return response()->json($corpu);
    }

    public function data(Request $request)
    {

        $data = Waarmeking::query();
        // return $data;
        return DataTables::eloquent($data)
            // ->addColumn('action', '<a href="{{route("waarmeking.edit-waarmeking",$data->id_waarmeking)}}" <i class="fa fa-edit" style="font-size:16px;color:blue"></i></a>
            //     <button <i class="fa fa-trash" style="font-size:16px;color:red"></i></button>')
            // ->addColumn('action', function(Waarmeking $waarmeking){
            //     return '<a href="" <i class="fa fa-edit" style="font-size:16px;color:blue"></i></a>
            //     <button class="btn btn-sm btn-danger">Delete</button>
            //      '; })->make(true)
            
            ->addColumn('action',function ($data) {
                $realisasi = '';
                $realisasi .= "<a href='" . route('waarmeking.edit-waarmeking', $data->id_waarmeking) . "' class='btn btn-icon btn-primary'><i class='fa fa-edit'></i></a>&nbsp;";
                // $realisasi .= "<a href='javascript:void(0);'' id='delete-product' data-toggle='tooltip' data-original-title='Delete' data-id='{{ $data->id_waarmeking }}' class='delete btn btn-danger'>Delete</a>";
                // $realisasi .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id}' onclick='deleteCorpu(this);'><i class='fa fa-trash'></i></a>&nbsp;";
                // $realisasi = $realisasi.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';\
                $realisasi .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger'  data-id='{$data->id}' onclick='deleteCorpu(this);'><i class='fa fa-trash'></i></a>&nbsp;";
                return $realisasi;
            })
            // ->addColumn('action', function ($id) {
            //     return '<a href="waarmeking/' . $id->id . '/edit" class="btn btn-primary">Edit</a>
            // "<a href='{{route('waarmeking')}}/create-waarmeking' <i class='fa fa-edit' style='font-size:16px;color:blue'></i></a>"
            //             <button class="btn" data-remote="/waarmeking/' . $id->id . '">Delete</button>
            //       '; })->make(true)
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }
}
