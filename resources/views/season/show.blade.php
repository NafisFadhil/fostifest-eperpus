@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Detail Season')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Detail Season')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('season.index') }}" class="btn btn-danger">Kembali</a>
                        <h3 class="card-title"></h3>
                    </div>
                    <!-- /.card-header -->
                    <form id="quickForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Masukkan Nama" value="{{ $data->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" id="start_date"
                                       placeholder="Masukkan Tanggal Mulai" value="{{ $data->start_date }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control" id="end_date"
                                       placeholder="Masukkan Tanggal Selesai" value="{{ $data->end_date }}" disabled>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </form>
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

        });
    </script>
@endpush
