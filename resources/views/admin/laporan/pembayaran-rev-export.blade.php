<html>
<table>
    <thead>
        <tr>
            <th colspan="5">
                Laporan Pembayaran Sumbangan Pembinaan Pendidikan
            </th>
        </tr>
        <tr>
            <th>No</th>
            <th>Bulan Pembayaran</th>
            <th>Jumlah Pembayaran</th>
            <th>Total Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @if (count($models) > 0)
            @foreach ($models as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['month'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ $item['total'] }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

</html>
