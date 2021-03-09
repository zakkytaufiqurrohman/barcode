@extends('layouts.master')

@section('title','Detail Akta PPAT')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Detail Akta PPAT</li>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('ppat') }}" class="btn btn-success">Kembali</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="aktappat-table" class="table table-bordered table-hover">
                <div class="row">
                    <div class="form-group">
                      <tr>
                        <td>No Urut</td>
                        <td>:</td>
                        <td>{{ $ppat->no_urut }}</td>
                      </tr>
                      <tr>
                        <td>No Akta</td>
                        <td>:</td>
                        <td>{{ $ppat->no_akta }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Akta</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($ppat->tanggal_akta)->isoFormat('D MMMM Y')}}</td>
                      </tr>
                      <tr>
                        <td>Bentuk Perbuatan Hukum</td>
                        <td>:</td>
                        <td>{{ $ppat->bentuk_hukum }}</td>
                      </tr>
                      <tr>
                        <td>Pihak Yang Memberikan</td>
                        <td>:</td>
                        <td>{{ $ppat->pihak1 }}</td>
                      </tr>
                      <tr>
                        <td>Pihak Yang Menerima</td>
                        <td>:</td>
                        <td>{{ $ppat->pihak2 }}</td>
                      </tr>
                      <tr>
                        <td>Nomor Hak</td>
                        <td>:</td>
                        <td>{{ $ppat->nomor_hak }}</td>
                      </tr>
                      <tr>
                        <td>Letak Tanah Dan Bangunan</td>
                        <td>:</td>
                        <td>{{ $ppat->letak_bangunan }}</td>
                      </tr>
                      <tr>
                        <td>Luas Tanah</td>
                        <td>:</td>
                        <td>{{ $ppat->luas_tanah }}</td>
                      </tr>
                      <tr>
                        <td>Luas Bangunan</td>
                        <td>:</td>
                        <td>{{ $ppat->luas_bangunan }}</td>
                      </tr>
                      <tr>
                        <td>Harga Transaksi</td>
                        <td>:</td>
                        <td>{{ $ppat->harga_transaksi }}</td>
                      </tr>
                      <tr>
                        <td>NOP/Tahun</td>
                        <td>:</td>
                        <td>{{ $ppat->nop_tahun }}</td>
                      </tr>
                      <tr>
                        <td>Nilai NJOP</td>
                        <td>:</td>
                        <td>{{ $ppat->nilai_njop }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal SSP</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($ppat->tanggal_ssp)->isoFormat('D MMMM Y') }}</td>
                      </tr>
                      <tr>
                        <td>Nilai SSP</td>
                        <td>:</td>
                        <td>{{ $ppat->nilai_ssp }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal SSB</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($ppat->tanggal_ssb)->isoFormat('D MMMM Y') }}</td>
                      </tr>
                      <tr>
                        <td>Nilai SSB</td>
                        <td>:</td>
                        <td>{{ $ppat->nilai_ssb }}</td>
                      </tr>
                      <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>{!! $ppat->keterangan !!}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Masuk BPN</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($ppat->tgl_masuk_bpn)->isoFormat('D MMMM Y') }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Selesai BPN</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($ppat->tgl_selesai_bpn)->isoFormat('D MMMM Y') }}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Penyerahan Clien</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($ppat->tgl_penyerahan_clien)->isoFormat('D MMMM Y') }}</td>
                      </tr>
                      <tr>
                        <td>No KTP</td>
                        <td>:</td>
                        <td>{{ $ppat->no_ktp }}</td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $ppat->alamat }}</td>
                      </tr>
                      <tr>
                        <tr>
                          <td>Pas Foto</td>
                          <td>:</td>
                          <td><img src="{{asset('GambarPasFoto/'.$ppat->pas_foto)}}" alt="Foto" width=80px heigth=80px></td>
                        </tr>
                        <tr>
                          <tr>
                            <td>Fota Akad</td>
                            <td>:</td>
                            <td><img src="{{asset('GambarFotoAkad/'.$ppat->foto_akad)}}" alt="Foto akad" width=80px heigth=80px></td>
                          </tr>
                          <tr>
                    </div>
                </div>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
@section('js')

<script>
</script>
@endsection