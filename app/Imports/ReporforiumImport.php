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
use Maatwebsite\Excel\Concerns\WithValidation;


HeadingRowFormatter::default('none');


class ReporforiumImport implements ToCollection,WithHeadingRow,WithValidation
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
                        'tanggal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Tanggal'])),
                        'waktu' => Carbon::now()->format('H:i:s'),
                        'password_berkas' => bcrypt(12345678),
                        'kode_berkas' => str_replace("/", "",bcrypt(date("Y-m-d h:i:sa").rand(10,100)))
                    ]);

                    $reporforium = Reporforium::create([
                        'id_berkas' => $berkas->id_berkas,
                        'nomor' => $row['Nomor'],
                        'no_bulanan' => $row['No Bulanan'],
                        'tanggal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Tanggal'])),
                        'sifat_akta' => $row['Sifat Akta'],
                        'berkas' => '',
                        'sk_kemenhumkam' => $row['SK Kemenhumham'],
        
                    ]);

                    $names = explode(',',$row['Nama Penghadap']);
                    // $nik = explode(',',$row['NIK']);

                    foreach ( $names as $idx => $val ) {
                        $data[] = [ 
                            'id_reporforium' => $reporforium->id_reporforium,
                            'nama' => $val, 
                            // 'nik' => $nik[$idx],
                            'foto' => 'empty'
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

    public function rules(): array
    {
        return [
            'Nomor' => 'required',
            'No Bulanan' => 'required',
            'Tanggal' => 'required',
            'Sifat Akta' => 'required',
            'SK Kemenhumham' => 'required',
            'Nama Penghadap' => 'required',
            'Password' => 'required|in:OFF,ON',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'Nomor.required' => 'Nomor tidak boleh kosong',
            'No Bulanan.required' => 'No bulanan tidak boleh kosong',
            'Tanggal.required' => 'Tanggal tidak boleh kosong',
            'Sifat Akta.required' =>'Siafat akta tidak boleh kosong',
            'SK Kemenhumham.required' => 'SK kemenhumham tidak boleh kosong',
            'Nama Penghadap.required' => 'Nama penghadap tidak boleh kosong',
            'Password.in' => 'Masukkan Data OFF atau ON',
            'Password.required' => 'Password tidak boleh kosong'
        ];
    }
}
