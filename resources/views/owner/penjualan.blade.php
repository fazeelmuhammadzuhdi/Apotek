<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-4 card card-danger">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-edit"></i> Data Customer</h3>
                        </div>
                    </div>
                    <hr style="border: 1px solid red;">
                    <form action="{{ route('penjualan.store') }}" method="POST" id="sample_form">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama Pasien</label>
                            <input type="text" class="form-control" autocomplete="off" name="nama" id="nama"
                                placeholder="Inputkan Nama Lengkap">
                            <input type="text" name="id" id="id" class="form-control" hidden>
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2" for="">Nomor Telp.</label>
                            <input type="text" class="form-control" onkeypress="return number(event)" name="telp"
                                id="telp" placeholder="Inputkan No Telepon" maxlength="12">
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
                // $('#btn-tutup').click()
                // $('#table').DataTable().ajax.reload()
                // $('#forms')[0].reset();
                toastr.success(response.text, 'Success')
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })
</script>
