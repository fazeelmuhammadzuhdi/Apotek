<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center">APOTIK FAZEEL</h1>
        <p style="font-size: 12px; text-align: center">Jl. Permata Harbaindo H13 No12 - Padang , 25227 <br>
            Telp. 083636272, E-Mail. fazeelmuhammadzuhdi@gmail.com
        </p>
        <hr style="border: 1px solid rgb(0, 78, 155)">


        <div class="row">
            <div>
                <table style="width: 40%">
                    <tr>
                        <td>No Nota</td>
                        <td>:</td>
                        <td>{{ $data[0]->nota }}</td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td>:</td>
                        <td>{{ $data[0]->customer }}</td>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td>:</td>
                        <td>{{ $data[0]->telp }}</td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td>:</td>
                        <td>{{ $data[0]->name }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr style="border: 1px solid red">
        <div>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Kemasan</th>
                        <th>Harga (Rp)</th>
                        <th>Total Harga (Jumlah)</th>
                    </tr>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama_obat }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->jual }}</td>
                            <td>{{ $item->subtotal }}</td>
                        </tr>
                    @endforeach
                </thead>
            </table>
            <h1 style="color: white"></h1>
            <h1 style="color: white"></h1>
            <hr style="border: 1px solid red">
        </div>
        <div>
            <table style="border:1em; width: 100%; table-layout: fixed">
                <tr>
                    <th width="40%"></th>
                    <th width="20%"></th>
                    <th width="15%"></th>
                    <th width="10%"></th>
                    <th width="15%"></th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total </td>
                    <td>: Rp.</td>
                    <td style="text-align: right">{{ number_format($bruto[0]->bruto, 2) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Discount </td>
                    <td>: Rp.</td>
                    <td style="text-align: right">{{ number_format($data[0]->diskon, 2) }}</td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Besar Uang </td>
                    <td>: Rp.</td>
                    <td style="text-align: right">{{ number_format($data[0]->dibayar, 2) }}</td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Pengembalian </td>
                    <td>: Rp.</td>
                    <td style="text-align: right">{{ number_format($data[0]->kembali, 2) }}</td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total Bersih </td>
                    <td>: Rp.</td>
                    <td style="text-align: right">{{ number_format($data[0]->total, 2) }}</td>

                </tr>
            </table>
            <hr style="border: 1px solid red">

        </div>

    </div>
</body>

</html>
