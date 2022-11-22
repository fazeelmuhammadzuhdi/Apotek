<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotik</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href={{ asset('plugins/fontawesome-free/css/all.min.css') }}>

    <link rel="stylesheet" href={{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}>

    {{-- <link rel="stylesheet" href={{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}> --}}

    {{-- <link rel="stylesheet" href={{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}> --}}

    {{-- <link rel="stylesheet" href={{ asset('plugins/jqvmap/jqvmap.min.css') }}> --}}

    <link rel="stylesheet" href={{ asset('dist/css/adminlte.min.css') }}>

    <link rel="stylesheet" href={{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}>
    <link rel="stylesheet" href={{ asset('plugins/datatables/datatables.css') }}>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('plugins/air-datepicker/air-datepicker.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    {{-- <link rel="stylesheet" href={{ asset('plugins/daterangepicker/daterangepicker.css') }}> --}}

    {{-- <link rel="stylesheet" href={{ asset('plugins/summernote/summernote-bs4.min.css') }}> --}}

    {{-- <script nonce="5afad67b-51f7-4bf2-a8c8-a96bf46798e6">
        (function(w, d) {
            ! function(e, f, g, h) {
                e.zarazData = e.zarazData || {};
                e.zarazData.executed = [];
                e.zaraz = {
                    deferred: [],
                    listeners: []
                };
                e.zaraz.q = [];
                e.zaraz._f = function(i) {
                    return function() {
                        var j = Array.prototype.slice.call(arguments);
                        e.zaraz.q.push({
                            m: i,
                            a: j
                        })
                    }
                };
                for (const k of ["track", "set", "debug"]) e.zaraz[k] = e.zaraz._f(k);
                e.zaraz.init = () => {
                    var l = f.getElementsByTagName(h)[0],
                        m = f.createElement(h),
                        n = f.getElementsByTagName("title")[0];
                    n && (e.zarazData.t = f.getElementsByTagName("title")[0].text);
                    e.zarazData.x = Math.random();
                    e.zarazData.w = e.screen.width;
                    e.zarazData.h = e.screen.height;
                    e.zarazData.j = e.innerHeight;
                    e.zarazData.e = e.innerWidth;
                    e.zarazData.l = e.location.href;
                    e.zarazData.r = f.referrer;
                    e.zarazData.k = e.screen.colorDepth;
                    e.zarazData.n = f.characterSet;
                    e.zarazData.o = (new Date).getTimezoneOffset();
                    if (e.dataLayer)
                        for (const r of Object.entries(Object.entries(dataLayer).reduce(((s, t) => ({
                                ...s[1],
                                ...t[1]
                            }))))) zaraz.set(r[0], r[1], {
                            scope: "page"
                        });
                    e.zarazData.q = [];
                    for (; e.zaraz.q.length;) {
                        const u = e.zaraz.q.shift();
                        e.zarazData.q.push(u)
                    }
                    m.defer = !0;
                    for (const v of [localStorage, sessionStorage]) Object.keys(v || {}).filter((x => x.startsWith(
                        "_zaraz_"))).forEach((w => {
                        try {
                            e.zarazData["z_" + w.slice(7)] = JSON.parse(v.getItem(w))
                        } catch {
                            e.zarazData["z_" + w.slice(7)] = v.getItem(w)
                        }
                    }));
                    m.referrerPolicy = "origin";
                    m.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(e.zarazData)));
                    l.parentNode.insertBefore(m, l)
                };
                ["complete", "interactive"].includes(f.readyState) ? zaraz.init() : e.addEventListener(
                    "DOMContentLoaded", zaraz.init)
            }(w, d, 0, "script");
        })(window, document);
    </script> --}}
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" class="btn btn-sm btn-info"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Apotik</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @role('owner')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-database text-success"></i>
                                    <p>
                                        Data Master
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('obat.index') }}" class="nav-link">
                                            <i class="fas fa-notes-medical nav-icon"></i>
                                            <p>Katalog Obat</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('stock.index') }}" class="nav-link">
                                            <i class="fas fa-notes-medical nav-icon"></i>
                                            <p>Stock Obat</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('pembelian.index') }}" class="nav-link">
                                            <i class="fas fa-notes-medical nav-icon"></i>
                                            <p>Data Pengeluaran</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('penjualan.index') }}" class="nav-link">
                                            <i class="fas fa-notes-medical nav-icon"></i>
                                            <p>Data Penjualan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('supplier.index') }}" class="nav-link">
                                            <i class="fas fa-notes-medical nav-icon"></i>
                                            <p>Data Supplier</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-notes-medical nav-icon"></i>
                                            <p>Opname Barang</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Transaksi
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-laptop-medical"></i>
                                            <p>Penjualan Barang</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-laptop-medical"></i>
                                            <p>Belanja Barang</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-laptop-medical"></i>
                                            <p>Laporan Pembayaran</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-header">Setting</li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p> Setting </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p> Tambah User </p>
                                </a>
                            </li>
                        @endrole
                        @role('gudang')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p> Katalog Obat </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p> Stock Obat </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p> Opname Barang </p>
                                </a>
                            </li>
                        @endrole
                        @role('kasir')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p> Stock Obat </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-money-bill text-danger"></i>
                                    <p> Transaksi Penjualan </p>
                                </a>
                            </li>
                        @endrole

                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <section class="content">
                <div class="container-fluid">
                    {{-- @role('owner')
                        <div class="row">
                            <div class="col-lg-3 col-6">

                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>150</h3>
                                        <p>New Orders</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">

                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>53<sup style="font-size: 20px">%</sup></h3>
                                        <p>Bounce Rate</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">

                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>44</h3>
                                        <p>User Registrations</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">

                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>65</h3>
                                        <p>Unique Visitors</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>
                    @endrole --}}

                    <div class="row">

                        <section class="col-lg-12 connectedSortable">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        {{-- <i class="fas fa-chart-pie mr-1"></i>
                                        Sales --}}
                                    </h3>
                                    {{-- <main> --}}
                                    {{ $slot }}
                                    {{-- </main> --}}
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>

        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>

    
    <script src={{ asset('plugins/jquery/jquery.min.js') }}></script>

    <script src={{ asset('plugins/jquery-ui/jquery-ui.min.js') }}></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src={{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}></script>

    <script src={{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}></script>

    <script src={{ asset('dist/js/adminlte.js') }}></script>

    <script src={{ asset('dist/js/demo.js') }}></script>

    <script src={{ asset('dist/js/pages/dashboard.js') }}></script>
    @stack('js')
</body>

</html>

{{-- @if (isset($header))
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endif --}}
