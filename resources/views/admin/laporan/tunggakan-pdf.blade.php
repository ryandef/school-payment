<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}

	</style>
    <div style="margin-bottom: 30px; padding: 20px 0; border-bottom: 1px solid #999; text-align: center;">
        <img style="height: 80px; object-fit: cover; " src="https://i.imgur.com/kOy3fAc.png" />
        <p>SMKN 1 Denpasar</p>
    </div>
	<center>
		<p style="font-family: Arial, Helvetica, sans-serif; margin-bottom: 0px;"><b>Laporan Tunggakan Pembayaran Sumbangan Pembinaan Pendidikan</b></p>
        <p style="font-family: Arial, Helvetica, sans-serif; ">Tahun Ajaran {{$tahun_ajaran->nama}}</p>
	</center>
    <br>
	<table class='table table-bordered'>
		<thead>
            <tr>
                <th>No</th>
                <th>Bulan Pembayaran</th>
                <th>Jumlah Tunggakan</th>
                <th>Total Tunggakan</th>
            </tr>
		</thead>
		<tbody>
			@if (count($models) > 0)
                @foreach ($models as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['month'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>Rp{{ number_format($item['total']) }}</td>
                </tr>
                @endforeach
            @endif
		</tbody>
	</table>

</body>
</html>
