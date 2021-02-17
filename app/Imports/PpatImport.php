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
use Maatwebsite\Excel\Concerns\WithValidation;

HeadingRowFormatter::default('none');

class PpatImport implements ToCollection,WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {
            DB::beginTransaction();
            try{
                $berkas = Berkas::create([
                    'password' => $row['19'],
                    'tipe_berkas' => 'aktappat',
                    'id_user' => Auth::user()->id_user,
                    'tanggal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['3'])),
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
                    'tanggal_ssp' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['14'])),
                    'nilai_ssp' => $row['15'],
                    'tanggal_ssb' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['16'])),
                    'nilai_ssb' => $row['17'],
                    'keterangan' => $row['18'],
                    'id_berkas' => $berkas->id_berkas,
                    'pas_foto' => 'empty',
                    'foto_akad' => 'empty',
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

    public function rules(): array
    {
        return [
            '1' => 'required',
            '2' => 'required',
            '3' => 'required',
            '4' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
            '8' => 'required',
            '8' => 'required',
            '10' => 'required',
            '11' => 'required',
            '12' => 'required',
            // '13' => 'required',
            // '14' => 'required',
            '15' => 'required',
            // '16' => 'required',
            '17' => 'required',
            // '18' => 'required',
            '19' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.required' => 'No urut tidak boleh kosong',
            '2.required' => 'No tidak boleh kosong',
            '3.required' => 'Tanggal akta tidak boleh kosong',
            '4.required' => 'Bentuk perbuatan hukum tidak boleh kosong',
            '5.required' => 'Pihak yang mengalihkan tidak boleh kosong',
            '6.required' => 'Pihak yang menerima tidak boleh kosong',
            '7.required' => 'Jenis dan nomor hak tidak boleh kosong',
            '8.required' => 'Letak dan luas bangunan tidak boleh kosong',
            '8.required' => 'Luas tanah tidak boleh kosong',
            '10.required' => 'Luas bangunan tidak boleh kosong',
            '11.required' => 'Nilai transaksi tidak boleh kosong',
            '12.required' => 'NOP tidak boleh kosong',
            // '13' => 'NOJP tidak boleh kosong',
            // '14' => 'Tanggal SPP tidak boleh kosong',
            '15.required' => 'Harga SPP tidak boleh kosong',
            // '16' => 'Tanggal SBB tidak boleh kosong',
            '17.required' => 'Harga SBB tidak boleh kosong',
            '19.required' => 'Password On/off tidak boleh kosong',
        ];
    }
}
