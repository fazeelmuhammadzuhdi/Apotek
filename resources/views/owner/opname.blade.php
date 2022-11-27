<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('opname-store') }}" method="POST" id="forms">
                        @csrf
                        <div class="form-group col-3">
                            <label for="">Obat</label>
                            <select name="obat" id="obat"
                                class="custom-select js-example-basic-single mr-sm-2 form-control">
                                <option value="">Pilih</option>
                                @foreach ($obat as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="">Stock Tersedia Di Sistem</label>
                            <input type="text" class="form-control" name="stock" id="stock" readonly>
                        </div>
                        <div class="form-group col-3">
                            <label for="">Stock Real</label>
                            <input type="text" class="form-control" name="real" id="real">
                        </div>
                        <div class="form-group col-3">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Masukkan Alasan"></textarea>
                        </div>
                        <div class="container mb-3">

                            <button class="btn btn-primary" id="simpan">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <div class="card-title"><i class="fas fa-user-edit"></i> Data Belanja Item</div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm" id="tabelbelanja">
                            <thead>
                                <tr>
                                    <th>Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Admin</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-6">
                        <div class="card card-danger">
                            <div class="card-header">
                                <div class="card-title"><i class="fas fa-user-edit"></i> Data Penjualan Item</div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm" id="tabeljual">
                            <thead>
                                <tr>
                                    <th>No Nota</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Admin</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@stack('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.8/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#obat').select2();
    });

    function loadbeli(id) {
        $('#tabelbelanja').DataTable({
            serverside: true,
            processing: true,
            ajax: {
                url: "{{ route('opname-databelanja') }}",
                data: {
                    id: id,
                }
            },
            columns: [{
                    data: 'nota',
                    name: 'nota'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                },
                {
                    data: 'qtys',
                    name: 'qtys'
                },

                {
                    data: 'name',
                    name: 'name',

                },
            ]
        })
    }

    function loadjual(id) {
        $('#tabeljual').DataTable({
            serverside: true,
            processing: true,
            ajax: {
                url: "{{ route('opname-datajual') }}",
                data: {
                    id: id,
                }
            },
            columns: [{
                    data: 'nota',
                    name: 'nota'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                },
                {
                    data: 'qty',
                    name: 'qty'
                },

                {
                    data: 'name',
                    name: 'name',

                },
            ]
        })
    }

    function getStock(id) {
        $.ajax({
            type: "post",
            url: "{{ route('opname-cekstock') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#stock').val(response.stock[0].stock)
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }

    $(document).on('change', '#obat', function() {
        let id = $(this).val()
        $('#stock').val(null);
        $('#real').val(null);
        $('#keterangan').val(null);
        $('#tabelbelanja').DataTable().destroy()
        $('#tabeljual').DataTable().destroy()
        loadbeli(id)
        loadjual(id)
        getStock(id)
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
                toastr.success(response.text, 'Success')
                // $('#table').DataTable().ajax.reload()
                $('#forms')[0].reset();
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })
</script>
