@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Tambah Izin')
@section('content_header_title', 'Master Absensi')
@section('content_header_subtitle', 'Tambah Izin')

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
            <div class="card-body">
							<div class="form-group">
                <label for="siswa">Siswa</label>
								<select name="siswa" class="form-control select2" data-dropdown-css-class="" style="width: 100%;" id="siswa">
									@foreach ($users as $item)
										<option value="{{ $item->id }}">{{ $item->name }}</option>
									@endforeach
								</select>
              </div>
              <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="Pilih Tanggal Izin">
              </div>
              <div class="form-group">
								<label for="durasi">Durasi Izin (Hari)</label>
                <input type="number" min="1" max="3" name="durasi" class="form-control" id="durasi" placeholder="Masukkan Durasi Izin">
              </div>
              <div class="form-group">
                <label for="surat">Surat Izin (Maksimal File 2MB)</label>
								<span class="text-danger">*Jadikan 1 file pdf jika surat lebih dari 1</span>
                <input type="file" name="surat" class="form-control" id="surat" placeholder="Masukkan Surat">
              </div>
							<div class="form-group">
								<label for="keterangan">Keterangan</label>
								<textarea name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan, Contoh : Izin..., Sakit..." rows="5"></textarea>
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
                url: '{{ route('master-izin.store') }}',
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
                        `{{ route('master-izin.index') }}`;
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
          siswa: {
            required: true,
          },
          tanggal: {
            required: true,
          },
					durasi: {
						required: true,
						min: 1,
						max: 3
					},
          surat: {
            required: true,
						extension: 'pdf|jpg|jpeg|png',
						filesize: 2
          },
					keterangan: {
						required: true,
					},
        },
        messages: {
          siswa: {
            required: "Siswa harus diisi",
          },
          tanggal: {
            required: "Tanggal harus diisi",
          },
          durasi: {
            required: "Durasi Izin harus diisi",
						min: "Durasi Izin minimal 1 hari",
						max: "Durasi Izin maksimal 3 hari"
          },
          surat: {
            required: "Surat harus diisi",
						extension: "Format file harus PDF, JPG, JPEG, atau PNG",
						filesize: "Ukuran file maksimal 2MB"
          },
          keterangan: {
            required: "Keterangan harus diisi",
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
