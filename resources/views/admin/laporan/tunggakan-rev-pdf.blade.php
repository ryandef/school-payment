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
                <th><small>No</small></th>
                <th><small>Kelas</small></th>
                @foreach ($bulan as $item)
                    <th><small>{{ $item }}</small></th>
                @endforeach
                <th><small>Jumlah</small></th>
            </tr>
        </thead>
		<tbody>
            @php
                $total_bayar = 0;
            @endphp
            @php
                $per_bulan = [];
            @endphp
            @forelse ($models as $i => $item)
                @php
                    $jumlah = 0;

                @endphp
                <tr>
                    <td><small>{{ $i + 1 }}</small></td>
                    <td><small>{{ $item['kelas'] }}</small></td>
                    @foreach ($item['bayar'] as $j => $bayar)
                        <td><small>{{ $bayar }}</small></td>
                        @php
                            $jumlah += $bayar;
                            $per_bulan[$j][$i] = $bayar;
                        @endphp
                    @endforeach
                    <td><small>{{ $jumlah }}</small></td>
                    {{-- <td>Rp{{ number_format($item['total']) }}</td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data</td>
                </tr>
            @endforelse

        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" align="center">
                    <small>Total</small>
                </td>

                @foreach ($per_bulan as $i => $per)
                    @php
                        $total_bayar += array_sum($per) * $ta->tagihan;
                    @endphp
                    <td>
                        <small>{{ number_format(array_sum($per) * $ta->tagihan) }}</small>
                    </td>
                @endforeach
                <td>
                    <small>{{ number_format($total_bayar) }}</small>
                </td>
            </tr>
        </tfoot>
	</table>

</body>
</html>
