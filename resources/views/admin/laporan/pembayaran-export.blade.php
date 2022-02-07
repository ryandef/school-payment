<html>
<table>
    <thead>
        <tr>
            <th colspan="5">
                Laporan Pembayaran Sumbangan Pembinaan Pendidikan Tahun Ajaran {{ $tahun_ajaran->nama }}
            </th>
        </tr>
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
                    <small>{{ array_sum($per) * $ta->tagihan }}</small>
                </td>
            @endforeach
            <td>
                <small>{{ $total_bayar }}</small>
            </td>
        </tr>
    </tfoot>
</table>

</html>
