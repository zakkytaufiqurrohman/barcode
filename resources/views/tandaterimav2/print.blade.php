<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
    </style>
    
    <table align="center"  >
        <tr>
            <td>
                <center>
                    <!-- <font size="4">KANTOR NOTARIS - PPAT</font><br>
                    <font size="4"><b>DYAH ASRI WURININGRUM, S.H., M.Kn.</b></font><br>
                    <font size="2">Puri Malangjiwan IV No. 1B, Malangjiwan, Colomadu, Karangayar</font><br>
                    <font size="2">Telp./Fax (0271) 7685446 / 082133088911</font> -->
                    {!!$setting->nama!!}
                </center>
                </td>
        </tr>
        <tr>
            <td colspan="2"><hr> </td>
        </tr>
        <tr>
            <td>
                <center>
                    <font size="2"><b>TANDA TERIMA BERKAS</b></font>
                </center>
            </td>
        </tr>
    </table><br>
    <table style="margin-left:40%">
        <tr>
            <td>Telah terima dari : {{$data->terima}}</td>
        </tr>
        <tr>
            <td>Berupa : {!!$data->berupa!!}</td>
        </tr>
        <tr>
            <td>Untuk Proses : {{$data->penerima}}</td>
        </tr>
        
    </table><br><br>

    <table align="right" width="60%" margin-left="40%"  >
        <tr>
            <td><center>Karangayar, Tgl {{ Carbon\Carbon::parse($data->tanggal)->isoFormat('D MMMM Y') }}</center></td>
        </tr>
       
    </table><br><br>

    <table align="left" width="20%" style="margin-left:5%"  >
        <tr>
            <td><center>Yang Menyerahkan</center></td>
        </tr>
        <tr>
            <td height="70"> </td>
        </tr>
        <tr>
            <td><center><u> {{$data->penyerah}} </u></center></td>
        </tr>
        
    </table>

    <table align="right" width="60%" margin-left="40%" >
        <tr>
            <td><center>Yang Menerima</center></td>
        </tr>
        <tr>
            <td height="70"> </td>
        </tr>
        <tr>
            <td><center><u> {{$data->penerima}} </u></center></td>
        </tr>
    </table><br><br><br><br><br><br><br>

    <table style="margin-left:40%">
        <tr>
            <td>Apabila sertifikat yang telah jadi lebih dari 3 (tiga) bulan</td><br>
        </tr>
        <tr>
            <td>tidak diambil, maka kehilangan/kerusakan diluar tanggung jawab kami.</td><br>
        </tr>
       
    </table><br><br>
        <?php
            $kode =  config('app.url').'/kwitansi/'.$data->berkas->kode_berkas; 
            echo DNS2D::getBarcodeHTML(strval($kode), 'QRCODE',3,3); 
        ?>

</body>
</html>