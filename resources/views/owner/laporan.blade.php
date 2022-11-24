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
                            <button type="button" class="btn btn-default" hidden id="btnModalJual" data-toggle="modal"
                                data-target="#modal-lg">
                                Launch Extra Large Modal
                            </button>
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
                        <button type="button" class="btn btn-default" hidden id="btnModalBeli" data-toggle="modal"
                            data-target="#modal-beli">
                            Launch Extra Large Modal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal JUAL --}}
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Penjualan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-sm text-center" style="width: 100%"
                        id="tabelDetailJual">
                        <thead>
                            <tr>
                                <td style="width: 2%">No</td>
                                <td>No Nota</td>
                                <td>Nama Obat</td>
                                <td style="text-align: center">QTY</td>
                                <td>Harga Obat</td>
                                <td>Diskon</td>
                                <td>Total</td>
                                <td>Customer</td>
                                <td>Kasir</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Beli --}}
    <div class="modal fade" id="modal-beli">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Belanja</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-responsive table-striped" id="tabelDetailBeli">
                        <thead>
                            <tr>
                                <td style="width: 2%">No</td>
                                <td>No Faktur</td>
                                <td>Tanggal</td>
                                <td>Nama Obat</td>
                                <td>Harga Obat</td>
                                <td style="text-align: center">QTY</td>
                                <td>Sub Total</td>
                                <td>Pajak</td>
                                <td>Diskon</td>
                                <td>Total</td>
                                <td>Customer</td>
                                <td>Kasir</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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


    function detailJual(id) {
        $('#tabelDetailJual').DataTable({
            rowOrder: true,
            columnsDefs: [{
                    orderable: true,
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
                url: "{{ route('detail-jual') }}",
                type: "post",
                data: {
                    nota: id
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
                    data: 'nota',
                    name: 'nota'
                },
                {
                    data: 'nama_obat',
                    name: 'nama_obat'
                },

                {
                    data: 'qty',
                    name: 'qty',

                },
                {
                    data: 'jual',
                    name: 'jual',
                    render: $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    data: 'diskon',
                    name: 'diskon',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'subtotal',
                    name: 'subtotal',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'customer',
                    name: 'customer',
                },
                {
                    data: 'name',
                    name: 'name',
                },
            ]
        })
    }

    $(document).on('click', '.detailJual', function() {
        let nota = $(this).attr('id');
        $('#tabelDetailJual').DataTable().destroy()
        detailJual(nota)
        $('#btnModalJual').click()

    });

    function detailBeli(id) {
        $('#tabelDetailBeli').DataTable({
            rowOrder: true,
            columnsDefs: [{
                    orderable: true,
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
                url: "{{ route('detail-beli') }}",
                type: "post",
                data: {
                    faktur: id
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
                    data: 'faktur',
                    name: 'faktur'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },

                {
                    data: 'item',
                    name: 'item',

                },
                {
                    data: 'harga',
                    name: 'harga',
                    render: $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    data: 'qty',
                    name: 'qty',
                },
                {
                    data: 'totalkotor',
                    name: 'totalkotor',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'pajak',
                    name: 'pajak',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'diskon',
                    name: 'diskon',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'totalbersih',
                    name: 'totalbersih',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'suppliers',
                    name: 'suppliers',
                    render: $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    data: 'name',
                    name: 'name',
                },
            ]
        })
    }

    $(document).on('click', '.detailBeli', function() {
        let faktur = $(this).attr('id');
        $('#tabelDetailBeli').DataTable().destroy()
        detailBeli(faktur)
        $('#btnModalBeli').click()

    });
</script>
