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
<table class="table table-striped">
    <tbody>
    <tr>
        <td width="20%">Nomor</td>
        <td width="20%">:</td>
        <td>{{$berkas->$nama->nomor}}</td>
    </tr>
    <tr>
        <td width="20%">Tanggal</td>
        <td width="20%">:</td>
        <td>{{ \Carbon\Carbon::parse($berkas->tanggal)->isoFormat('D MMMM Y') }}</td>
    </tr>
    <tr>
        <td width="20%">Penyetor</td>
        <td width="20%">:</td>
        <td>{!! $berkas->$nama->penyetor !!}</td>
    </tr>
    <tr>
        <td width="20%">Penerima</td>
        <td width="20%">:</td>
        <td>{!! $berkas->$nama->penerima !!}</td>
    </tr>
    <tr>
        <td width="20%">Mengetahui</td>
        <td width="20%">:</td>
        <td>{!! $berkas->$nama->mengetahui !!}</td>
    </tr>
    <tr>
        <td>Uraian/ Jumlah</td>
        <td>:</td>
        <td>
            <?php $no = 1 ?>
            @foreach($berkas->$nama->urai as $ok)
                {{$no }}. {{$ok->uraian}} | {{$ok->jumlah}} 
                <br>
                <br>
                <?php $no++?>
            @endforeach
        </td>
      </tr>
      <tr>
        <?php $row = count($berkas->$nama->urai) + 1?>
         <td rowspan = "{{$row}}">Terima dari : {{$berkas->terima}}</td>
         <td width="20%"><b>Uraian<b></td>
         <td width="20%"><b>Jumlah</b></td>
     </tr>
      <?php $total = 0?>
        @foreach($berkas->$nama->urai as $uraian)
            <tr>
                <td width="20%">{{$uraian->uraian}}</td>
                <td width="20%">{{number_format($uraian->jumlah)}}</td>
            </tr>
            <?php
                $total += intval($uraian->jumlah);
            ?>
        @endforeach
        <tr>
            <td></td>
            <td width="20%"><b>Terbilang:</b> {{terbilang($total)}}</td>
            <td width="20%"><b>total:</b> {{number_format($total)}} </td>
        </tr>
    </tbody>
</table>