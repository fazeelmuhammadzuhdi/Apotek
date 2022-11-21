<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-12 card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Data Pembelian</h3>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-9">
                                <form action="{{ route('pembelian.store') }}" method="POST" id="form-beli">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="">No Pembelian</label>
                                            <input type="text" class="form-control" autocomplete="off" name="faktur"
                                                id="faktur" readonly value="{{ $nomer }}">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">Tanggal</label>
                                            <input type="text" class="form-control" name="tanggal" id="tanggal"
                                                readonly value="{{ $time }}">
                                        </div>
                                        <div class="form-group col-3">
                                            <label class="mr-sm-2">Nama Supplier</label>
                                            <select name="supplier" id="supplier"
                                                class="custom-select js-example-basic-single mr-sm-2 form-control">
                                                <option value="" selected disabled>Pilih</option>
                                                @foreach ($supp as $id => $nama)
                                                    <option value="{{ $id }}">{{ $nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-3">
                                            <label class="mr-sm-2">Kode Barang</label>
                                            <select name="kode" id="kode"
                                                class="custom-select js-example-basic-single mr-sm-2 form-control"
                                                required>
                                                <option value="" selected disabled>Masukkan Kode</option>
                                                @foreach ($kode as $key)
                                                    <option value="{{ $key->id }}">{{ $key->kode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="">Nama Barang</label>
                                            <input type="text" class="form-control" name="item" id="item"
                                                autocomplete="off">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">Harga Barang</label>
                                            <input type="text" class="form-control" name="harga" id="harga"
                                                autocomplete="off" onkeypress="return number(event)" maxlength="10"
                                                value="0">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">Jumlah Pembelian</label>
                                            <input type="text" class="form-control" name="qty" id="qty"
                                                autocomplete="off" onkeypress="return number(event)" maxlength="4"
                                                value="0">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">Sub Total</label>
                                            <input type="text" class="form-control" name="subtotal" id="subtotal"
                                                autocomplete="off" onkeypress="return number(event)" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="">Pajak</label>
                                            <input type="text" class="form-control" name="pajak" id="pajak"
                                                value="0" autocomplete="off" onkeypress="return number(event)"
                                                maxlength="2">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">Diskon</label>
                                            <input type="text" class="form-control" name="diskon" id="diskon"
                                                value="0" autocomplete="off" onkeypress="return number(event)"
                                                maxlength="2">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">keterangan</label>
                                            <input type="text" class="form-control" name="keterangan"
                                                id="keterangan" autocomplete="off">
                                        </div>
                                    </div>

                                    <hr style="border: 1px solid red">
                                    <div class="mb-3 ml-2">
                                        <button type="submit" id="tambahSimpan" name="tambahSimpan"
                                            class="btn btn-success"><i
                                                class="far fa-save"></i><i>&nbsp;&nbsp;&nbsp;</i>
                                            Simpan</button>
                                        <button type="button" id="buka" name="buka"
                                            class="btn btn-primary"><i
                                                class="fas fa-plus-circle"></i><i>&nbsp;&nbsp;&nbsp;</i>
                                            Tambah Item</button>
                                    </div>
                                </form>
                                <br><br>
                                <div class="card card-info table-responsive">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-shopping-bag">&nbsp;</i>Keranjang
                                        </h3>
                                    </div>
                                    <table class="table table-bordered table-striped table-sm" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No .</th>
                                                <th>Supplier</th>
                                                <th>Nama Obat</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Pajak</th>
                                                <th>Diskon</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <button type="button" id="proses" name="proses" class="btn btn-warning"><i
                                        class="nav-icon far fa-save"></i>&nbsp;&nbsp;&nbsp;
                                    Acc / Proses
                                </button>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Dibayar Dengan</label>
                                    <select name="metode" id="metode" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Hutang">Hutang</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Total Kotor</label>
                                    <input type="text" class="form-control" name="ttlkotor" id="ttlkotor"
                                        autocomplete="off" readonly onkeypress="return number(event)">
                                </div>
                                <div class="form-group">
                                    <label for="">Besar Pajak</label>
                                    <input type="text" class="form-control" name="ttlpajak" id="ttlpajak"
                                        autocomplete="off" readonly onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="form-group">
                                    <label for="">Besar Diskon</label>
                                    <input type="text" class="form-control" name="ttldiskon" id="ttldiskon"
                                        autocomplete="off" readonly onkeypress="return isNumberKey(event)"
                                        value="0" maxlength="2">
                                </div>
                                <div class="form-group">
                                    <label for="">Total Bersih / Yang Harus Dibayar</label>
                                    <input type="text" class="form-control" name="grand" id="grand"
                                        autocomplete="off" readonly onkeypress="return number(event)">
                                </div>
                                <div class="form-group">
                                    <label for="">Pembayaran Sebesar</label>
                                    <input type="text" class="form-control" name="dibayar" id="dibayar"
                                        autocomplete="off" onkeypress="return number(event)"
                                        placeholder="Kosongkan Jika Metode Pembayaran Cash / Tunai">
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan Beli</label>
                                    <input type="text" class="form-control" name="keteranganbeli"
                                        id="keteranganbeli" autocomplete="off">
                                </div>

                                <button type="button" id="simpanBeli" class="btn btn-secondary mb-3"><i
                                        class="nav-icon"></i>&nbsp;Simpan</button>

                                {{-- <form action="" method="POST">
                                    @csrf
                                </form> --}}
                                {{-- <button id="baru" class="transaksiBaru btn btn-warning"><i
                                        class="nav-icon"></i>Pembelian Baru</button> --}}
                            </div>
                        </div>
                        <br>
                    </div>
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
    // });

    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }


    $(document).on('change', '#kode', function() {
        carikode($(this).val());
    })

    function carikode(kode) {
        $.ajax({
            type: "post",
            url: "{{ route('carikode') }}",
            data: {
                kode: kode,
            },
            success: function(response) {
                if (response.length > 0) {
                    $('#item').val(response[0].nama)
                } else {
                    $('#item').val(null)
                }
                console.log(response);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }

    $(document).on('blur', '#qty', function() {
        let harga = parseInt($('#harga').val())
        let qty = parseInt($(this).val())
        $('#subtotal').val(qty * harga)
    });

    $(document).on('blur', '#harga', function() {
        let harga = parseInt($('#harga').val())
        let qty = parseInt($('#qty').val())
        $('#subtotal').val(qty * harga)
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
                // $('#obat').prop('disabled', true)
                // $('#qty').attr('disabled', true)
                // $('#diskon').attr('disabled', true)
                // $('#tambah').hide()
                // $('#table1').DataTable().ajax.reload()
                // $('#form-beli')[0].reset();
                toastr.success(response.text, 'Success')
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })
</script>
