<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-4 card card-danger">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-edit"></i> Data Customer</h3>
                        </div>

                        <hr style="border: 1px solid red;">
                        <form action="{{ route('penjualan.store') }}" method="POST" id="sample_form">
                            @csrf
                            <div class="form-group">
                                <label for="">Nama Pasien</label>
                                <input type="text" class="form-control" autocomplete="off" name="nama"
                                    id="nama" placeholder="Inputkan Nama Lengkap" autofocus>
                                <input type="text" name="id" id="id" class="form-control" hidden>
                            </div>
                            <div class="form-group">
                                <label class="mr-sm-2" for="">Nomor Telp.</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    name="telp" id="telp" placeholder="Inputkan No Telepon" maxlength="12">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="5" class="form-control" placeholder="Inputkan Alamat"></textarea>
                            </div>
                            <hr style="border: 1px solid red;">
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="mr-sm-2" for="">Nomor Resep</label>
                                        <input type="text" class="form-control" name="resep" id="resep"
                                            placeholder="Inputkan No Telepon">
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="mr-sm-2" for="">Pengirim</label>
                                        <input type="text" class="form-control" name="pengirim" id="pengirim"
                                            placeholder="Inputkan Pengirim">
                                    </div>
                                </div>
                            </div>

                    </div>
                    <hr style="border: 1px solid red;">
                    <br>
                    <div class="col-7 card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Data Pembelian</h3>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-3">
                                <label for="">Obat</label>
                                <select name="obat" id="obat"
                                    class="custom-select js-example-basic-single mr-sm-2 form-control">
                                    <option value="">Pilih</option>
                                    @foreach ($obat as $item)
                                        <option value="{{ $item->idObat }}">{{ $item->namaObat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Stock Tersedia</label>
                                <input type="text" class="form-control" name="stock" id="stock" readonly>
                            </div>
                            <div class="form-group col-3">
                                <label for="">No Kwitansi</label>
                                <input type="text" class="form-control" name="no" id="no" readonly
                                    value="{{ $nomer }}">
                            </div>
                            <div class="form-group col-3">
                                <label for="">Tanggal</label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" readonly
                                    value="{{ $tanggals }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="qty">Jumlah Pembelian</label>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-danger btn-sm m-2">-</button>
                                    <input type="text" class="form-control" id="qty"
                                        name="qty"></input>
                                    <button type="button" class="btn btn-success btn-sm m-2">+</button>
                                </div>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Harga</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    name="harga" id="harga">
                            </div>
                            <div class="form-group col-3">
                                <label for="">Diskon</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    name="diskon" id="diskon">
                            </div>
                            <div class="form-group col-3">
                                <label for="">Total Harga</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    name="total" id="total" readonly>
                            </div>
                            <hr style="border: 1px solid red;">
                            <div class="form-group col-3">
                                <button type="submit" class="btn btn-success" id="tambah" name="tambah"><i
                                        class="fas fa-save"></i>
                                    Simpan
                                </button>
                            </div>
                            </form>
                            <button type="submit" class="btn btn-primary mt-3" id="buka" name="buka"><i
                                    class="fas fa-plus"></i>
                                Tambah Obat
                            </button>
                        </div>
                        <br>
                        <br>
                        <div class="card card-primary table-responsive">
                            <table class="table table-bordered table-striped table-sm" id="table1">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Obat</th>
                                        <th>QTY</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-3">

                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">
                                {{-- <form action="" method="">
                                    @csrf
                                </form> --}}

                                <button type="button" class="btn btn-info mb-3" id="btn-bayar" name="btn-bayar"
                                    data-toggle="modal" data-target="#modal-info" id="btn-modal"><i
                                        class="fas fa-money-bill-wave"></i>
                                    Proses
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h4 class="modal-title">Transaksi Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="pembayaran">
                        @csrf
                        <div>
                            Form Pembayaran
                            <hr style="border: 1px solid red">
                            <div class="row">
                                <div class="col-6">
                                    <label for="nota" class="mr-sm-2">Nota Penjualan</label>
                                    <input type="text" class="form-control" onkeypress="return number(event)"
                                        name="nota" id="nota" autocomplete="off" readonly>
                                </div>
                                <div class="col-6" style="margin-top: 40px">
                                    <label for="label-warning">Kasir :</label> <span
                                        class="badge badge-info">{{ Auth::user()->name }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="totalharga" class="mr-sm-2">Total Harga</label>
                            <input type="text" class="form-control" onkeypress="return number(event)"
                                name="totalharga" id="totalharga" readonly autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="diskon">Diskon</label>
                            <input type="text" class="form-control" name="diskonn" id="diskonn"
                                onkeypress="return number(event)" readonly autocomplete="off" value="0">
                        </div>
                        <div class="form-group">
                            <label for="yangHarus" class="mr-sm-2">Harga Yang Harus Di Bayar</label>
                            <input type="text" class="form-control" onkeypress="return number(event)"
                                name="yangHarus" id="yangHarus" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dibayar">Di Bayar</label>
                            <input type="text" class="form-control" onkeypress="return number(event)"
                                name="dibayar" id="dibayar">
                        </div>
                        <div class="form-group">
                            <label for="kembalian">Uang Kembalian</label>
                            <input type="text" class="form-control" onkeypress="return number(event)"
                                name="kembalian" id="kembalian" autocomplete="off" disabled>
                        </div>

                        <button type="button" id="simpanBayar"
                            class="btn btn-outline-light btn-success btn-block">Bayar</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" name="batal" id="btn-tutup" class="btn btn-outline-light"
                        data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
@stack('js')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.8/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>

<script>
    // $(document).ready(function() {
    //     $('#obat').select2();
    // });

    //Input Harus Number
    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $('#obat').change(function() {
        let id = $(this).val();
        $.ajax({
            type: "post",
            url: "{{ route('getdata.obat') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#harga').val(response.jual)
                $('#stock').val(response.stock)
            }
        });
    })

    $(document).on('blur', '#qty', function() {
        let harga = parseInt($('#harga').val())
        let qty = parseInt($(this).val())
        let stock = parseInt($('#stock').val()) - qty
        $('#total').val(qty * harga)
        $('#stock').val(stock)
    });

    $(document).on('submit', 'form', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                // menutup tombol simpan ketika di sudah di click
                $('#obat').prop('disabled', true)
                $('#qty').attr('disabled', true)
                $('#diskon').attr('disabled', true)
                $('#tambah').hide()
                $('#table1').DataTable().ajax.reload()
                // $('#sample_form')[0].reset();
                toastr.success(response.text, 'Success')
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })

    $('#table1').DataTable({
        serverside: true,
        processing: true,
        ajax: {
            url: "{{ route('penjualan.data') }}",
            data: {
                id: $('#no').val()
            }
        },
        columns: [{
                data: null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'nama_obat',
                name: 'nama_obat'
            },
            {
                data: 'qty',
                name: 'qty'
            },
            {
                data: 'jual',
                name: 'jual',
            },
            {
                data: 'subtotal',
                name: 'subtotal',

            },

            {
                data: 'aksi',
                name: 'aksi',
                orderable: false
            },
        ]
    })

    $(document).on('click', '.hapus', function() {
        let id = $(this).attr('id');
        $.ajax({
            type: "post",
            url: "{{ route('penjualan.hapus') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // console.log(response);
                $('#table1').DataTable().ajax.reload()
                toastr.success(response.text, 'Success')
                // $('#sample_form')[0].reset();

            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })

    $('#buka').click(function() {
        $('#tambah').show()
        $('#obat').prop('disabled', false)
        $('#qty').attr('disabled', false)
        $('#qty').val(null)
        $('#diskon').val(null)
        $('#diskon').attr('disabled', false)
    })

    $(document).click(function() {
        let id = $('#no').val();
        $.ajax({
            type: "post",
            url: "{{ route('hitung') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#totalharga').val(response.data[0].totalHarga)
                $('#diskonn').val(response.diskon)
                $('#yangHarus').val(parseInt(response.data[0].totalHarga) - parseInt(response
                    .diskon))
                $('#nota').val(response.data[0].nota)
            }
        });
    })

    $(document).on('blur', '#dibayar', function() {
        let a = parseInt($('#yangHarus').val())
        let b = $(this).val();
        let c = b - a

        if (c < 0) {
            toastr.info('Periksa Inputan', 'Info')
            $('#simpanBayar').hide()
        } else {
            $('#kembalian').val(c)
            $('#simpanBayar').show()
        }
    })
</script>
