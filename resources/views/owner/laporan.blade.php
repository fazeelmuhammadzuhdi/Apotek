<x-app-layout>
    <div class="py-12">
        <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                aria-selected="true">Laporan Penjualan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Laporan Belanja</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                            aria-labelledby="custom-tabs-one-home-tab">
                            <table class="table table-bordered table-striped table-sm" id="tablepenjualan">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>No Nota</td>
                                        <td>Tanggal</td>
                                        <td>Diterima</td>
                                        <td>Diskon</td>
                                        <td>Kasir</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-one-profile-tab">
                            <table class="table table-bordered table-striped table-sm" style="width: 100%"
                                id="tablebelanja">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>No Faktur</td>
                                        <td>Tanggal</td>
                                        <td>Supplier</td>
                                        <td>Item</td>
                                        <td>Total</td>
                                        <td>Kasir</td>
                                        <td>Aksi</td>
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
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready(function() {
        loadJual()
        loadBelanja()
    });
</script>
<script>
    function loadJual() {
        $('#tablepenjualan').DataTable({
            rowOrder: true,
            columnsDefs: [{
                    orderable: false,
                    classname: 'reorder',
                    targets: 0
                },
                {
                    orderable: false,
                    targets: '_all'
                }
            ],
            serverside: true,
            processing: true,
            responsive: true,
            ajax: {
                url: "{{ route('dataTablePenjualan') }}",

            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nota',
                    name: 'nota'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },

                {
                    data: 'totals',
                    name: 'totals',

                },
                {
                    data: 'diskons',
                    name: 'diskons',
                    render: $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    data: 'name',
                    name: 'name',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },

                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
            ]
        })
    }

    function loadBelanja() {
        $('#tablebelanja').DataTable({
            rowOrder: true,
            columnsDefs: [{
                    orderable: false,
                    classname: 'reorder',
                    targets: 0
                },
                {
                    orderable: false,
                    targets: '_all'
                }
            ],
            serverside: true,
            processing: true,
            responsive: true,
            ajax: {
                url: "{{ route('dataTableBelanja') }}",

            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'faktur',
                    name: 'faktur'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },

                {
                    data: 'suppliers',
                    name: 'suppliers',

                },
                {
                    data: 'item',
                    name: 'item',

                },
                {
                    data: 'totals',
                    name: 'totals',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'name',
                    name: 'name',

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
