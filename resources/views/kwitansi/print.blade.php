<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
    <?php
        function penyebut($nilai) {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                $temp = penyebut($nilai - 10). " belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
            }     
            return $temp;
        }

        function terbilang($nilai) {
            if($nilai<0) {
                $hasil = "minus ". trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }     		
            return $hasil;
        }
    ?>
    <table class='table table-bordered'>
        <tr>
            <td rowspan = 2 colspan="3"><p>{!! $setting->nama !!}</p></td>
            <td rowspan = 2 colspan="1"><h5><b>BUKTI PEMBAYARAN</b></h5></td>
            <td>nomor : {{$data->nomor}}</td>
        </tr>
        <tr>
            <td>tanggal : {{$data->tanggal}}</td>
        </tr>
        <tr>
           <?php $row = count($data->urai) + 1?>
            <td rowspan = "{{$row}}">Terima dari : {{$data->terima}}</td>
            <td colspan="3">Uraian</td>
            <td >Jumlah</td>
        </tr>
        <?php $total = 0?>
        @foreach($data->urai as $uraian)
            <tr>
                <td colspan="3">{{$uraian->uraian}}</td>
                <td>{{$uraian->jumlah}}</td>
            </tr>
            <?php
                $total += intval($uraian->jumlah);
            ?>
        @endforeach
        <tr>
            <td colspan = 4> <b>Terbilang:</b> {{terbilang($total)}}</td>
            <td><b>total:</b> {{$total}} </td>
        </tr>
        <tr>
            <td colspan = 2 rowspan="1">Catatan: {{$data->catatan}}</td>
            <td>Penyetor</td>
            <td>Mengetahui</td>
            <td>Penerima</td>
        </tr>
        <tr>
            <td colspan = 2 style="height:40"></td>
            <td>{{$data->penyetor}}</td>
            <td>{{$data->mengetahui}}</td>
            <td>{{$data->penerima}}</td>
        </tr>
        <?php
            $kode =  config('app.url').'/berkas/kwitansi/'.$data->berkas->kode_berkas; 
            echo DNS2D::getBarcodeHTML(strval($kode), 'QRCODE',3,3); 
        ?>
    </table>
</body>
</html>