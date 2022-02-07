<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    #invoice-POS {
        padding: 2mm;
        margin: 0 auto;
        width: 64mm;
        background: #FFF;
    }

    #invoice-POS ::selection {
        background: #f31544;
        color: #FFF;
    }

    #invoice-POS ::moz-selection {
        background: #f31544;
        color: #FFF;
    }

    #invoice-POS h1 {
        font-size: 1.5em;
        color: #222;
    }

    #invoice-POS h2 {
        font-size: 0.9em;
    }

    #invoice-POS h3 {
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
    }

    #invoice-POS p {
        font-size: 0.7em;
        color: #666;
        line-height: 1.2em;
    }

    #invoice-POS #top,
    #invoice-POS #mid,
    #invoice-POS #bot {
        /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
    }

    #invoice-POS #mid {
        min-height: 40px;
    }

    #invoice-POS #bot {
        min-height: 50px;
    }

    #invoice-POS .info {
        display: block;
        margin-left: 0;
    }

    #invoice-POS .title {
        float: right;
    }

    #invoice-POS .title p {
        text-align: right;
    }

    #invoice-POS table {
        width: 100%;
        border-collapse: collapse;
    }

    #invoice-POS .tabletitle {
        font-size: 0.5em;
        background: #EEE;
    }

    #invoice-POS .service {
        border-bottom: 1px solid #EEE;
    }

    #invoice-POS .item {
        width: 24mm;
    }

    #invoice-POS .itemtext {
        font-size: 0.5em;
    }

    #invoice-POS #legalcopy {
        margin-top: 5mm;
        text-align: center;
    }

    .total {
        padding: 10px;
        text-align: center;
        border: 1px dashed #222;
    }

    .total h5 {
        margin: 10px 0;
    }

</style>

<div id="invoice-POS">

    <center id="top">
        <div class="info">
            <h2>SMKN 1 Denpasar</h2>
            <h2>{{ $model->invoice }}</h2>
        </div>
        <!--End Info-->
    </center>
    <!--End InvoiceTop-->

    <div id="mid">
        <div class="info">
            <p>

                <strong>NIS</strong> : {{ $model->siswa->nis }}<br>
                <strong>Nama</strong> : {{ $model->siswa->nama }}<br>
                <strong>Waktu Bayar</strong> : {{ date('d M Y, H:i:s', strtotime($model->waktu_diterima)) }} <br>

            </p>
            <hr>
            @foreach ($model->detail as $item)
                <p>
                    <strong class="text-gray-800">{{ date('M Y', strtotime($item->bulan)) }}</strong>
                    (Rp{{ number_format($item->total) }})
                </p>
            @endforeach
        </div>
    </div>
    <!--End Invoice Mid-->

    <div id="bot">
        @if ($model->discount > 0)
            <p>
                <b>Potongan Beasiswa: </b> Rp{{ number_format($model->discount) }} <br>
            </p>
        @endif
        <div class="total">
            <h5>Rp {{ number_format($model->total) }}</h5>
        </div>

        <div id="legalcopy">
            <p class="legal"><strong>Terima Kasih!</strong> <br>Semoga Sukses
            </p>
        </div>

    </div>
    <!--End InvoiceBot-->
</div>
<!--End Invoice-->


<script>
    window.print();
</script>
