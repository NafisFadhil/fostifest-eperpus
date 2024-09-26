@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Detail Izin')
@section('content_header_title', 'Master Absensi')
@section('content_header_subtitle', 'Detail Izin')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('master-izin.index') }}" class="btn btn-danger">Kembali</a>
            <h3 class="card-title"></h3>
          </div>
          <!-- /.card-header -->
          <form id="quickForm">
						@method('PUT')
            <div class="card-body">
							<div class="form-group">
                <label for="siswa">Siswa</label>
								<select name="siswa" class="form-control select2" data-dropdown-css-class="" style="width: 100%;" id="siswa" disabled>
									<option value="{{ $izin->user_id }}">{{ $izin->user->name }}</option>
								</select>
              </div>
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="Pilih Tanggal Izin" value="{{ $izin->tanggal }}" disabled>
              </div>
              <div class="form-group">
								<label for="durasi">Durasi Izin (Hari)</label>
                <input type="number" min="1" max="3" name="durasi" class="form-control" id="durasi" placeholder="Masukkan Durasi Izin" value="{{ $izin->qty }}" disabled>
              </div>
              <div class="form-group">
                <label for="surat">Surat Izin (Maksimal File 2MB)</label>
								<br>
								<a href="{{ asset('storage/' . $izin->attachment) }}" download><i class="fas fa-download"></i> Unduh Surat</a>
              </div>
							<div class="form-group">
								<label for="keterangan">Keterangan</label>
								<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan, Contoh : Izin..., Sakit..." rows="5" disabled>{{ $izin->keterangan }}</textarea>
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
  </script>
@endpush
