<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Reporforium;
use App\Models\DetailReporforium;
use DB;

class KlaperController extends Controller
{
    function index()
    {
        return view('klaper.index');
    }

    public function data(Request $request)
    {
        $dates = request()->get('date') ?? null;

        $date = explode(' - ',$dates);

        // $data = DetailReporforium::query();
        $data = DB::table('detail_reporforium')
                ->join('tbl_reporforium','detail_reporforium.id_reporforium','=','tbl_reporforium.id_reporforium')
                ->orderBy('nama','ASC');

        if($dates!=null)    
            $data = $data->whereBetween('tanggal',$date);

        $data = $data->get();
        // return var_dump($data);
        // $data->orderBy('nama','ASC');
        return DataTables::of($data)
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
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }
}
