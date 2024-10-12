@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Laporan Bulanan')
@section('content_header_title', 'Laporan')
@section('content_header_subtitle', 'Laporan Bulanan')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-0 ps-10">
                        <div class="row g-8 align-items-end">
                            <div class="col-lg-2">
                                <div class="form-label">Kelas</div>
                                <select name="kelas" class="form-control select2" data-dropdown-css-class=""
                                        style="width: 100%;" id="kelas" data-placeholder="Kelas" placeholder="Kelas">
                                    <option value="all" selected>Semua Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-label">Bulan</div>
                                <select name="bulan" class="form-control select2" data-dropdown-css-class=""
                                        style="width: 100%;" id="bulan" data-placeholder="Bulan" placeholder="Bulan">
                                    @foreach ($bulan as $key => $item)
                                        <option {{ $key == date('m') ? 'selected' : '' }} value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-label">Tahun</div>
                                <select name="tahun" class="form-control select2" data-dropdown-css-class=""
                                        style="width: 100%;" id="tahun" data-placeholder="Tahun" placeholder="Tahun">
                                    @foreach ($tahun as $key => $item)
                                        <option {{ $key == date('Y') ? 'selected' : '' }} value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
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
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        $(function () {
            var table = $("#myTable").DataTable({
                responsive: true,
                "order": [],
                "ajax": {
                    url: '{{ route('laporan_harian.data') }}',
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
            $("#filter-table").on('click', function () {
                var kelas = $("#season").val();
                var date = $("#date").val();

                // Update the DataTable with the selected filters
                table.ajax.url('{{ route('laporan_harian.data') }}' + '?season=' + kelas +
                    '&date=' +
                    date).load();
            });
        });
    </script>
@endpush
