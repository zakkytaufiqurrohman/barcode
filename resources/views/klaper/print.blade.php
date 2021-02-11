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
    <center>
			<h4>Laporan Klaper</h4>
            <h5>Tanggal {{\Carbon\Carbon::parse($date[0])->isoFormat('D MMMM Y')}} - {{\Carbon\Carbon::parse($date[1])->isoFormat('D MMMM Y')}}</h5>
	</center>
    
    <table border="1" class="table table-striped">
        <tr>
            <th>Nomor Urut</th>
            <th>Nomor Bulanan</th>
            <th>Nomor Tanggal Ata</th>
            <th>Sifat Akta</th>
            <th>Nama Penghapan dan atau kuasa</th>
        </tr>
        
        @foreach($klapers as $klaper)
            <tr>
                <td>{{$klaper->nomor}}</td>
                <td>{{$klaper->no_bulanan}}</td>  
                <td>{{\Carbon\Carbon::parse($klaper->tanggal)->isoFormat('D MMMM Y')}}</td>
                <td>{{$klaper->sifat_akta}}</td>  
                <td>
                   {{$klaper->nama}}
                </td>
            </tr>
        @endforeach  
        
    </table>
</body>
</html>