@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Detail User')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Detail User')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('user.index') }}" class="btn btn-danger">Kembali</a>
            <h3 class="card-title"></h3>
          </div>
          <!-- /.card-header -->
          <form id="quickForm">
						@csrf
						@method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama" value="{{ $user->name }}" disabled>
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username" value="{{ $user->username }}" disabled>
              </div>
              <div class="form-group">
                <label for="role">Hak Akses</label>
								<select name="role" class="form-control select2" data-dropdown-css-class="" style="width: 100%;" id="role" disabled>
									<option selected value="{{ $user->role_id }}">{{ $user->role->name }}</option>
								</select>
              </div>
              <div class="form-group" id="selectKelasContainer">
                <label for="kelas">Kelas</label>
								<select name="kelas" class="form-control select2" data-dropdown-css-class="" style="width: 100%;" id="kelas" disabled>
									<option selected value="{{ $user?->kelas_id }}">{{ $user?->kelas?->name }}</option>
								</select>
              </div>
            </div>
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
			$('.select2').select2({
				theme: 'bootstrap4'
			});
			@if ($user->role->code != "MEMBER")
				$('#selectKelasContainer').hide();
			@endif
    });
  </script>
@endpush
