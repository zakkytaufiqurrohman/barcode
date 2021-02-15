<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Berkas;
use App\Models\Ppat;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class PpatImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {
            // var_dump($row['18']);die;
            DB::beginTransaction();
            try{
                $berkas = Berkas::create([
                    'password' => $row['19'],
                    'tipe_berkas' => 'aktappat',
                    'id_user' => Auth::user()->id_user,
                    'tanggal' => Carbon::parse($row['3'])->format('Y-m-d'),
                    'waktu' => Carbon::now()->format('H:i:s'),
                    'password_berkas' => bcrypt(12345678),
                    'kode_berkas' => str_replace("/", "",bcrypt(date("Y-m-d h:i:sa").rand(10,100)))
                ]);
               
                Ppat::create([
                    'no_urut' => $row['1'] ,
                    'no_akta' => $row['2'] ,
                    'tanggal_akta' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['3'])),
                    'bentuk_hukum' => $row['4'],
                    'pihak1' => $row['5'],
                    'pihak2' => $row['6'],
                    'nomor_hak' => $row['7'],
                    'letak_bangunan' => $row['8'],
                    'luas_tanah' => $row['9'],
                    'luas_bangunan' => $row['10'],
                    'harga_transaksi' => $row['11'],
                    'nop_tahun' => $row['12'],
                    'nilai_njop' => $row['13'],
                    'tanggal_ssp' => \Carbon\Carbon::parse($row['14'])->format('Y-m-d'),
                    'nilai_ssp' => $row['15'],
                    'tanggal_ssb' => \Carbon\Carbon::parse($row['16'])->format('Y-m-d'),
                    'nilai_ssb' => $row['17'],
                    'keterangan' => $row['18'],
                    'id_berkas' => $berkas->id_berkas,
                ]);
                DB::commit();

            } catch(Exception $e) {
                DB::rollback();
            }

        }
    }

    public function headingRow(): int
    {
        return 3;
    }
}
