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

    public function data(Request $request)
    {

        $data = Waarmeking::query();
        // return $data;
        return DataTables::eloquent($data)
            // ->addColumn('realisasi',function ($data) {
            //     $realisasi = '';
            //     $realisasi = $data->nomor;
            //     return $realisasi;
            // })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }
}
