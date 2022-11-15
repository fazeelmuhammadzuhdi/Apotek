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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready(function() {
        loaddata()
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
</script>
