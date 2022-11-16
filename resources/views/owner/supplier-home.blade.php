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
                            <th>Telpon</th>
                            <th>Email</th>
                            <th>Rekening</th>
                            <th>Alamat</th>
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
                    <form action="{{ route('supplier.store') }}" method="POST" id="forms">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Supplier</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="Inputkan Nama Supplier">
                            <input type="text" hidden class="form-control" name="id" id="id"
                                placeholder="Inputkan Nama Supplier">
                        </div>

                        <div class="form-group">
                            <label for="telp">No Telpon</label>
                            <input type="text" class="form-control" onkeypress="return number(event)" name="telp"
                                id="telp" placeholder="Inputkan No Telepon">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="text" class="form-control" name="email" id="email"
                                placeholder="Inputkan Email">
                        </div>
                        <div class="form-group">
                            <label for="rekening">No. Rekening</label>
                            <input type="text" class="form-control" onkeypress="return number(event)" name="rekening"
                                id="rekening" placeholder="Inputkan No Rekening">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="5" class="form-control" placeholder="Alamat Email"></textarea>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" name="batal" id="btn-tutup" class="btn btn-outline-light"
                                data-dismiss="modal">Close</button>
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
                url: "{{ route('supplier.index') }}"
            },
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'telp',
                    name: 'telp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'rekening',
                    name: 'rekening'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
            ]
        })
    }

    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

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
                toastr.success(response.text, 'Success')

            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal!')
            }
        });
    })

    //EDIT
    $(document).on('click', '.edit', function() {
        $('#forms').attr('action', "{{ route('supplier.update') }}")
        let id = $(this).attr('id')
        $.ajax({
            type: "post",
            url: "{{ route('supplier.edit') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                $('#id').val(response.id)
                $('#nama').val(response.nama)
                $('#telp').val(response.telp)
                $('#alamat').val(response.alamat)
                $('#rekening').val(response.rekening)
                $('#email').val(response.email)
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
                    url: "{{ route('supplier.hapus') }}",
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
