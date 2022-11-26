<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="card card-warning">
            <div class="card-header">
                <div class="card-title">Katalog stock</div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table table-striped" id="table" style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Nama Obat</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stock</th>
                            <th>Keterangan</th>
                            <th>Update Terakhir</th>
                            <th>Admin</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <button type="button" class="btn btn-info" id="btn-tambah" data-toggle="modal" data-target="#modal-info">
            Tambah
        </button>
    </div>

    <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">Form Tambah Stock stock</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('stock.store') }}" method="POST" id="forms">
                        @csrf
                        <div class="form-group">
                            <label for="obat" class="mr-sm-2">Nama Obat</label>
                            <select class="custom-select mr-sm-2 js-example-basic-single form-control" name="obat"
                                id="obat">
                                <option value="" selected disabled>--Pilih Obat--</option>
                                @foreach ($obat as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            Stock Obat
                            <hr style="border: 1px solid red;">
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="mr-sm-2" for="">Stock Awal</label>
                                <input type="text" class="form-control" autocomplete="off" name="stockawal"
                                    id="stockawal" readonly value="0">
                                <input type="text" hidden class="form-control" autocomplete="off" name="id"
                                    id="id" placeholder="Inputkan Nama obat">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Masuk</label>
                                <input type="text" class="form-control" autocomplete="off" name="masuk"
                                    id="masuk" value="0" onkeypress="return number(event)">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="mr-sm-2">Keluar</label>
                                <input type="text" class="form-control" autocomplete="off" name="keluar"
                                    id="keluar" value="0" onkeypress="return number(event)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2">Stock Akhir</label>
                            <input type="text" class="form-control" autocomplete="off" name="stock" id="stock"
                                value="0" onkeypress="return number(event)" readonly>
                        </div>
                        <div>
                            Stock Obat
                            <hr style="border: 1px solid rgba(239, 7, 7, 0.934);">
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2">Harga Beli</label>
                            <input type="text" class="form-control" autocomplete="off" name="beli" id="beli"
                                onkeypress="return number(event)" maxlength="12">
                        </div>
                        <div class="form-group">
                            <label for="">Harga Jual</label>
                            <input type="text" class="form-control" autocomplete="off" name="jual" id="jual"
                                onkeypress="return number(event)" maxlength="12">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Expired</label>
                            <input type="date" class=" form-control" autocomplete="off" name="expired"
                                id="expired" onkeypress="return number(event)">
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan"
                                placeholder="Inputkan Keterangan">
                        </div>
                        <button type="submit" id="simpan"
                            class="btn btn-outline-light btn-success btn-block">Simpan</button>
                        <div class="mt-3">
                            <button type="button" name="batal" id="btn-tutup" hidden
                                class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
{{-- <script src="{{ asset('plugins/air-datepicker/air-datepicker.js') }}"></script> --}}
{{-- <script src="{{ asset('plugins/air-datepicker/locale/en.js') }}"></script> --}}
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.8/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        loaddata()
        // $('#obat').select2();
        toastr.info('Are you the 6 fingered man?')
    });

    function loaddata(params) {
        $('#table').DataTable({
            serverside: true,
            processing: true,
            ajax: {
                url: "{{ route('stock.index') }}"
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'namaObat',
                    name: 'namaObat'
                },
                {
                    data: 'beli',
                    name: 'beli'
                },
                {
                    data: 'jual',
                    name: 'jual'
                },
                {
                    data: 'stock',
                    name: 'stock'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'admins',
                    name: 'admins'
                },

                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
            ]
        })
    }

    //Input Harus Number
    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    //Mengirim Data
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
                $('#btn-tutup').click()
                $('#table').DataTable().ajax.reload()
                $('#forms')[0].reset();
                toastr.success(response.text, 'Success')

            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })

    $(document).on('change', '#obat', function() {
        let id = $(this).val()
        $.ajax({
            type: "post",
            url: "{{ route('get.obat') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // $('#stockawal').val(response.data.stock)
                console.log(response);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    })

    $(document).on('blur', '#masuk', function() {
        let awal = parseInt($('#stockawal').val())
        let masuk = parseInt($('#masuk').val())
        let keluar = parseInt($('#keluar').val())

        let akhir = (awal + masuk) - keluar
        $('#stock').val(akhir)
    })

    $(document).on('blur', '#keluar', function() {
        let awal = parseInt($('#stockawal').val())
        let masuk = parseInt($('#masuk').val())
        let keluar = parseInt($('#keluar').val())

        let akhir = (awal + masuk) - keluar
        $('#stock').val(akhir)
    })

    $(document).on('click', '.edit', function() {
        $('#forms').attr('action', "{{ route('stock.update') }}")
        $('#btn-tambah').click()
        let id = $(this).attr('id')
        $.ajax({
            type: "post",
            url: "{{ route('stock.edit') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                let newOption = new Option(response.namaObat, response.IdObat, true, true)
                $('#obat').append(newOption).trigger('change');
                $('#id').val(response.id);
                $('#obat').prop('disabled', true);
                $('#stockawal').val(response.stock);
                $('#beli').val(response.beli);
                $('#jual').val(response.jual);
                $('#expired').val(response.expired);
                $('#keterangan').val(response.keterangan);
                console.log(response);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })

    $(document).on('click', '.hapus', function() {
        let id = $(this).attr('id')
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "{{ route('stock.hapus') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response, status) {
                        if (status = '200') {
                            setTimeout(() => {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data Berhasil Di Hapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((response) => {
                                    $('#table').DataTable().ajax.reload()

                                })
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal Menghapus!',
                        })
                    }
                });
            }
        })

    })
</script>
