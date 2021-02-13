<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Berkas;
use App\Models\DetailReporforium;
use App\Models\Reporforium;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');


class ReporforiumImport implements ToCollection,WithHeadingRow  
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {
            if(!empty($row['Nomor'])){
                DB::beginTransaction();
                try{
                    $berkas = Berkas::create([
                        'password' => $row['Password'],
                        'tipe_berkas' => 'reporforium',
                        'id_user' => Auth::user()->id_user,
                        'tanggal' => Carbon::parse($row['Tanggal'])->format('Y-m-d') ,
                        'waktu' => Carbon::now()->format('H:i:s'),
                        'password_berkas' => bcrypt(12345678),
                        'kode_berkas' => str_replace("/", "",bcrypt(date("Y-m-d h:i:sa").rand(10,100)))
                    ]);

                    $reporforium = Reporforium::create([
                        'id_berkas' => $berkas->id_berkas,
                        'nomor' => $row['Nomor'],
                        'no_bulanan' => $row['No Bulanan'],
                        'tanggal' => Carbon::parse($row['Tanggal'])->format('Y-m-d') ,
                        'sifat_akta' => $row['Sifat Akta'],
                        'berkas' => '',
                        'sk_kemenhumkam' => $row['SK Kemenhumkam'],
        
                    ]);

                    $names = explode(',',$row['Nama Penghadap']);
                    $nik = explode(',',$row['NIK']);

                    foreach ( $names as $idx => $val ) {
                        $data[] = [ 
                            'id_reporforium' => $reporforium->id_reporforium,
                            'nama' => $val, 
                            'nik' => $nik[$idx],
                            'foto' => ''
                        ];
                    }
                    DetailReporforium::insert($data);
                    DB::commit();
                    
                } catch(Exception $e) {
                    DB::rollback();
                }
            }
        }
    }
}
