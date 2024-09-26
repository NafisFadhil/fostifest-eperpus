@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kehadiran')
@section('content_header_title', 'Absensi')
@section('content_header_subtitle', 'Kehadiran')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <form id="quickForm">
                        <div class="card-body">
                            <input type="hidden" name="lat">
                            <input type="hidden" name="long">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" id="tanggal"
                                       placeholder="Pilih Tanggal Izin" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="photo_attendance">Foto Absen</label>
                                <input type="file" name="photo_attendance" class="form-control" id="photo_attendance" accept="image/*" capture>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="keterangan"
                                          placeholder="Masukkan Keterangan, bisa disi '-'" rows="5"></textarea>
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
            $('.select2').select2({
                theme: 'bootstrap4'
            });
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
                                url: '{{ route('absen.store') }}',
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
                                                `{{ route('home') }}`;
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
                    tanggal: {
                        required: true,
                    },
                    keterangan: {
                        required: true,
                    },
                    photo_attendance: {
                        required: true,
                        extension: "jpg|jpeg|png",
                        filesize: 2097152
                    }
                },
                messages: {
                    tanggal: {
                        required: "Tanggal harus diisi",
                    },
                    photo_attendance: {
                        required: "Foto absen harus diisi",
                        extension: "Foto absen harus berupa file gambar (jpg, jpeg, png)",
                        filesize: "Ukuran file foto absen maksimal 2MB"
                    },
                    keterangan: {
                        required: "Keterangan harus diisi",
                    },
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

        var gpsPermission = false;
        navigator.permissions.query({
            name: 'geolocation'
        })
            .then(permission => {
                permission.onchange = function () {
                    if (permission.state == 'denied') {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Silahkan berikan akses GPS',
                            icon: 'warning'
                        }).then(function() {
                            location.reload()
                        });
                        gpsPermission = false;
                    } else {
                        gpsPermission = true;
                    }
                }
                if (permission.state == 'denied') {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Silahkan berikan akses GPS',
                        icon: 'warning'
                    }).then(function() {
                        location.reload()
                    });
                    gpsPermission = false;
                } else {
                    gpsPermission = true;
                }
                if (gpsPermission == false) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Silahkan berikan akses GPS',
                        icon: 'warning'
                    }).then(function() {
                        location.reload()
                    });
                    return;
                }
            });

        navigator.geolocation.getCurrentPosition(function (location) {
            $('input[name="lat"]').val(location.coords.latitude);
            $('input[name="long"]').val(location.coords.longitude);
        }, function (e) {
            // console.log(e);
        }, {
            timeout: 10000,
            enableHighAccuracy: true
        })
    </script>
@endpush
