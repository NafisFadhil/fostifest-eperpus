@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Tambah User')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Tambah User')

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
            <div class="card-body">
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama">
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username">
              </div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control" id="password" placeholder="Password">
							</div>
							<div class="form-group row">
								<div class="col-sm-10">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="showPassword">
										<label class="form-check-label" for="showPassword">Show Password</label>
									</div>
								</div>
							</div>
              <div class="form-group">
                <label for="role">Hak Akses</label>
								<select name="role" class="form-control select2" data-dropdown-css-class="" style="width: 100%;" id="role">
									@foreach ($role as $item)
										<option value="{{ $item->id }}">{{ $item->name }}</option>
									@endforeach
								</select>
              </div>
              <div class="form-group" id="selectKelasContainer">
                <label for="kelas">Kelas</label>
								<select name="kelas" class="form-control select2" data-dropdown-css-class="" style="width: 100%;" id="kelas">
									@foreach ($kelas as $item)
										<option value="{{ $item->id }}">{{ $item->name }}</option>
									@endforeach
								</select>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
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
			$('#role').change(function() {
				if ($("#role option:selected").text() == "Member") {
					$('#selectKelasContainer').show();
				} else {
					$('#selectKelasContainer').hide();
				}
			});
			$('#showPassword').change(function() {
				if ($(this).is(':checked')) {
					$('#password').attr('type', 'text');
				} else {
					$('#password').attr('type', 'password');
				}
			})
      $.validator.setDefaults({
        submitHandler: function() {
					var form = $('#quickForm');
          Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyimpan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
          }).then((result) => {
            if (result.isConfirmed) {
              // Create a new FormData object to include form data
              var formData = new FormData(form[0]);

              // Add the CSRF token to the form data
              formData.append('_token', $('input[name="_token"]').val());

              // Perform AJAX form submission
              $.ajax({
                url: '{{ route('user.store') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                  Swal.fire({
                    title: 'Silahkan tunggu',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                  });
                  Swal.showLoading();
                },
                success: function(response) {
                  if (response.status == true) {
                    Swal.fire({
											title: "Berhasil!",
                      text: "Data berhasil disimpan",
                      icon: "success",
                    }).then(() => {
                      window.location.href =
                        `{{ route('user.index') }}`;
                    });
                  } else {
										Swal.fire({
                    title: 'Gagal!',
                    text: xhr.responseJSON.message,
                    icon: 'warning'
                  });
									} 
                },
                error: function(xhr) {
                  Swal.fire({
                    title: 'Gagal!',
                    text: xhr.responseJSON.message,
                    icon: 'warning'
                  });
                },
                complete: function() {
                  Swal.hideLoading();
                }
              });
            }
          });
        }
      });
      $('#quickForm').validate({
        rules: {
          name: {
            required: true,
          },
          username: {
            required: true,
          },
					password: {
						required: true,
						minlength: 5
					},
          role: {
            required: true,
          },
        },
        messages: {
          name: {
            required: "Nama harus diisi",
          },
          username: {
            required: "Username harus diisi",
          },
					password: {
						required: "Password harus diisi",
						minlength: "Password minimal 5 karakter"
					},
          role: {
            required: "Hak akses harus diisi",
          },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
@endpush
