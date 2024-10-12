@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Tambah Season')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Tambah Season')

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
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Masukkan Nama">
                            </div>
                            <div class="form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" id="start_date"
                                       placeholder="Masukkan Tanggal Mulai">
                            </div>
                            <div class="form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control" id="end_date"
                                       placeholder="Masukkan Tanggal Selesai">
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
        $(function () {
            $.validator.setDefaults({
                submitHandler: function () {
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
                                url: '{{ route('season.store') }}',
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                beforeSend: function () {
                                    Swal.fire({
                                        title: 'Silahkan tunggu',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    });
                                    Swal.showLoading();
                                },
                                success: function (response) {
                                    if (response.status == true) {
                                        Swal.fire({
                                            title: "Berhasil!",
                                            text: "Data berhasil disimpan",
                                            icon: "success",
                                        }).then(() => {
                                            window.location.href =
                                                `{{ route('season.index') }}`;
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: xhr.responseJSON.message,
                                            icon: 'warning'
                                        });
                                    }
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: xhr.responseJSON.message,
                                        icon: 'warning'
                                    });
                                },
                                complete: function () {
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
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Nama harus diisi",
                    },
                    start_date: {
                        required: "Tanggal mulai harus diisi"
                    },
                    end_date: {
                        required: "Tanggal selesai harus diisi"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
