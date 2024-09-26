@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Detail Kelas')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Detail Kelas')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('kelas.index') }}" class="btn btn-danger">Kembali</a>
            <h3 class="card-title"></h3>
          </div>
          <!-- /.card-header -->
          <form id="quickForm">
						@csrf
						@method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama" value="{{ $data->name }}" disabled>
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
    $(function() {
      
    });
  </script>
@endpush
