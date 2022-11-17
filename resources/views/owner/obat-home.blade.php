<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table table-striped" id="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Dosis</th>
                            <th>Indikasi</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
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
                    <h4 class="modal-title">Info Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('obat.store') }}" method="POST" id="forms">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama obat</label>
                            <input type="text" class="form-control" autocomplete="off" name="nama" id="nama"
                                placeholder="Inputkan Nama obat">
                            <input type="text" hidden class="form-control" autocomplete="off" name="id"
                                id="id" placeholder="Inputkan Nama obat">
                        </div>

                        <div class="form-group">
                            <label for="kode">Kode Obat</label>
                            <input type="text" class="form-control" maxlength="8" autocomplete="off" name="kode"
                                id="kode" placeholder="Inputkan Kode Obat">
                        </div>
                        <div class="form-group">
                            <label for="dosis">Dosis</label>
                            <input type="text" class="form-control" autocomplete="off" name="dosis" id="dosis"
                                placeholder="Inputkan Dosis">
                        </div>
                        <div class="form-group">
                            <label for="indikasi">Indikasi</label>
                            <input type="text" class="form-control" autocomplete="off" name="indikasi" id="indikasi"
                                placeholder="Inputkan Indikasi">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select autocomplete="off" name="satuan" id="satuan" class="form-control">
                                <option value="" selected disabled>--Pilih Satuan--</option>
                                @foreach ($satuan as $item)
                                    <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select autocomplete="off" name="kategori" id="kategori" class="form-control">
                                <option value="" selected disabled>--Pilih kategori--</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" autocomplete="off" name="batal" id="btn-tutup"
                                class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" id="simpan" class="btn btn-outline-light">Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.8/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        loaddata()
        toastr.info('Are you the 6 fingered man?')
    });

    function loaddata(params) {
        $('#table').DataTable({
            serverside: true,
            processing: true,
            ajax: {
                url: "{{ route('obat.index') }}"
            },
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'dosis',
                    name: 'dosis'
                },
                {
                    data: 'indikasi',
                    name: 'indikasi'
                },
                {
                    data: 'kategoris',
                    name: 'kategoris'
                },
                {
                    data: 'satuans',
                    name: 'satuans'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
            ]
        })
    }

    // function number(evt) {
    //     var charCode = (evt.which) ? evt.which : event.keyCode
    //     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    //         return false;
    //     }
    //     return true;
    // }

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

    //EDIT
    $(document).on('click', '.edit', function() {
        $('#forms').attr('action', "{{ route('obat.update') }}")
        let id = $(this).attr('id')
        $.ajax({
            type: "post",
            url: "{{ route('obat.edit') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#id').val(response.id)
                $('#nama').val(response.nama)
                $('#kode').val(response.kode)
                $('#dosis').val(response.dosis)
                $('#indikasi').val(response.indikasi)
                $('#satuan').val(response.satuan)
                $('#kategori').val(response.kategori)
                $('#btn-tambah').click()
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    })


    //HAPUS
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
                    url: "{{ route('obat.hapus') }}",
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
