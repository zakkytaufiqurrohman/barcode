<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waarmeking;
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

    public function store(Request $request)
    {

        $data = Waarmeking::create([
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal,
            'pihak1' => $request->pihak1,
            'pihak2' => $request->pihak2,
            'isi' => $request->isi,
            'id_berkas' => ('123456789'),
            ]);
        // dd($data);
        return redirect('waarmekings');
    }

    public function data(Request $request)
    {

        $data = Waarmeking::query();
        // return $data;
        return DataTables::eloquent($data)
            ->addColumn('action', '<a href="" <i class="fa fa-edit" style="font-size:16px;color:blue"></i></a>
                <button <i class="fa fa-trash" style="font-size:16px;color:red"></i></button>'
                 )
            // ->addColumn('action', function(Waarmeking $waarmeking){
            //     return '<a href="" <i class="fa fa-edit" style="font-size:16px;color:blue"></i></a>
            //     <button class="btn btn-sm btn-danger">Delete</button>
            //      '; })->make(true)
            
            // ->addColumn('realisasi',function ($data) {
            //     $realisasi = '';
            //     $realisasi = $data->nomor;
            //     return $realisasi;
            // })
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
