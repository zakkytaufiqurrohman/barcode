<?php

namespace App\Imports;

use Illuminate\Support\Collection;
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
            
            // var_dump($row['Password']);
            // die;
            DB::beginTransaction();
            try{
                $berkas = Berkas::create([
                    'password' => $row['Password'],
                    'tipe_berkas' => 'reporforium',
                    'id_user' => 15,
                    'tanggal' => Carbon::parse($row['Tanggal'])->format('Y-m-d') ,
                    'waktu' => Carbon::now()->format('H:i:s'),
                    'password_berkas' => 'rahasiailahi',
                    'kode_berkas' => 'oke bos'
                ]);
                // var_dump($row['Passwords']);
                // die;
                $reporforium = Reporforium::create([
                    'id_berkas' => $berkas->id_berkas,
                    'nomor' => $row['Nomor'],
                    'no_bulanan' => $row['No Bulanan'],
                    'tanggal' => Carbon::parse($row['Tanggal'])->format('Y-m-d') ,
                    'sifat_akta' => $row['Sifat Akta'],
                    'berkas' => '',
                    'sk_kemenhumkam' => $row['SK Kemenhumkam'],
    
                ]);
                // var_dump($reporforium->id_reporforium);
                $names = explode(',',$row['Nama Penghadap']);
                foreach($names as $name){
                    $data [] = [
                        'id_reporforium' => $reporforium->id_reporforium,
                        'foto' => '',
                        'nik' => '',
                        'nama' => $name
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
