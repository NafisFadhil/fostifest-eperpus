@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Level')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Tambah Level')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tambah Level</h3>
          </div>
          <!-- /.card-header -->
          <form id="quickForm">
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-6">
                    <label for="nama_buku">Nama Level</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Judul Buku">
                </div>
                <div class="form-group col-md-6">
                    <label for="sampul">Minimal Poin</label>
                    <input type="number" name="min_poin" class="form-control" id="min_poin" placeholder="Masukkan Jumlah Minimal Poin">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                    <label for="nama_buku">Maksimal Pinjam Buku</label>
                    <input type="number" name="max_pinjam_buku" class="form-control" id="max_pinjam_buku" placeholder="Masukkan Jumlah Maksimal Pinjam Buku">
                </div>
                <div class="form-group col-md-6">
                    <label for="sampul">Reset Poin</label>
                    <input type="number" name="reset_poin" class="form-control" id="reset_poin" placeholder="Masukkan Jumlah Reset Poin">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('master-level.index') }}" class="btn btn-danger">Kembali</a>
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
@endpush

{{-- Push extra scripts --}}

@push('js')
  <script>
    $(document).ready(function () {
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

                        // Perform AJAX form submission
                        $.ajax({
                            url: '{{ route('master-level.store') }}',
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
                                // Swal.showLoading();
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: "Data berhasil disimpan",
                                        icon: "success",
                                    }).then(() => {
                                        window.location.href = `{{ route('master-level.index') }}`;
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message,
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
                    minlength: 3
                },
                min_poin: {
                    required: true,
                    number: true,
                    min: 1
                },
                max_pinjam_buku: {
                    required: true,
                    number: true,
                    min: 1
                },
                reset_poin: {
                    required: true,
                    number: true,
                    min: 1
                }
            },
            messages: {
                name: {
                    required: "Masukkan Nama Level",
                    minlength: "Minimal 3 karakter"
                },
                min_poin: {
                    required: "Minimal Poin harus diisi",
                    number: "Masukkan angka yang valid",
                    min: "Minimal Poin harus lebih besar dari 0"
                },
                max_pinjam_buku: {
                    required: "Maksimal Pinjam Buku harus diisi",
                    number: "Masukkan angka yang valid",
                    min: "Maksimal Pinjam Buku harus lebih besar dari 0"
                },
                reset_poin: {
                    required: "Reset Poin harus diisi",
                    number: "Masukkan angka yang valid",
                    min: "Reset Poin harus lebih besar dari 0"
                }
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
