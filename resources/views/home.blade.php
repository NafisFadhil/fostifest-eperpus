@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')
    <p>Selamat datang {{ auth()->user()->name }}.</p>
    @can('siswa')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if($absen)
                        @if($absen->date_out == null)
                            <div class="card-header">
                                <a href="{{ route('absen.index') }}" class="btn btn-primary">Absen Keluar</a>
                                <h3 class="card-title"></h3>
                            </div>
                        @else
                        @endif
                    @else
                        <div class="card-header">
                            <a href="{{ route('absen.index') }}" class="btn btn-primary">Absen Masuk</a>
                            <h3 class="card-title"></h3>
                        </div>
                    @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Durasi</th>
                                <th>Keterangan Masuk</th>
                                <th>Keterangan Keluar</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    @endcan
    @can('superadmin', 'admin')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-0 ps-10">
                        <div class="row g-8 align-items-end">
                            <div class="col-lg-2">
                                <div class="form-label">Kelas</div>
                                <select name="kelas" class="form-control select2" data-dropdown-css-class="" style="width: 100%;" id="kelas" data-placeholder="Kelas" placeholder="Kelas">
                                    <option value="all" selected>Semua Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-label">Tanggal</div>
                                <input type="date" name="date" id="date" class="form-control flatpickr-input"
                                       placeholder="Tanggal" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary me-5 mt-2" id="filter-table">
                                    <i class="fas fa-search"></i>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Durasi</th>
                                <th>Keterangan Masuk</th>
                                <th>Keterangan Keluar</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    @endcan
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    @can('siswa')

    <script>
        $(function() {
            var table = $("#myTable").DataTable({
                responsive: true,
                "order": [],
                "ajax": {
                    url: '{{ route('home.data') }}',
                    type: 'GET',
                },
                "columns": [
                    {
                        data: 'date_attendance'
                    },
                    {
                        data: 'hour_in'
                    },
                    {
                        data: 'hour_out'
                    },
                    {
                        data: 'duration'
                    },
                    {
                        data: 'noted_in'
                    },
                    {
                        data: 'noted_out'
                    }
                ]
            });
        });
    </script>
    @endcan
    @can('superadmin', 'admin')

    <script>
        $(function() {
            var table = $("#myTable").DataTable({
                responsive: true,
                "order": [],
                "ajax": {
                    url: '{{ route('home.data.admin') }}',
                    type: 'GET',
                },
                "columns": [
                    {
                        data: 'student_name'
                    },
                    {
                        data: 'date_attendance'
                    },
                    {
                        data: 'hour_in'
                    },
                    {
                        data: 'hour_out'
                    },
                    {
                        data: 'duration'
                    },
                    {
                        data: 'noted_in'
                    },
                    {
                        data: 'noted_out'
                    }
                ]
            });

            // Filter data
            $("#filter-table").on('click', function() {
                var kelas = $("#kelas").val();
                var date = $("#date").val();

                // Update the DataTable with the selected filters
                table.ajax.url('{{ route('home.data.admin') }}' + '?kelas=' + kelas +
                    '&date=' +
                    date).load();
            });
        });
    </script>
    @endcan
@endpush
