@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Buku')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Tambah Buku')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tambah Buku</h3>
          </div>
          <!-- /.card-header -->
          <form id="quickForm">
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-6">
                    <label for="nama_buku">Judul Buku</label>
                    <input type="text" name="nama_buku" class="form-control" id="" value="{{ $data->title }}" placeholder="Masukkan Judul Buku">
                </div>
                <div class="form-group col-md-6">
                    <label for="sampul">Sampul Buku</label>
                    <div>
                        <img style="width: 256px" src="{{ asset($data->cover) }}" alt="">
                        <p class="text-danger">*Tidak perlu upload sampul lagi apabila tidak ingin mengganti sampul</p>
                        <input type="file" name="sampul" class="form-control" id="" placeholder="Masukkan Sampul">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                    <label for="deskripsi">Deskripsi Buku</label>
                    <textarea name="deskripsi" class="form-control" id="" cols="30" rows="10">{{ $data->description }}</textarea>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_book">Kategori Buku</label>
                        <input name="tags" id="bookCategoryTags" class="form-control" value="{{ $data->tags }}" placeholder="Add book categories...">
                    </div>
                    <div class="form-group">
                        <label for="minimal_poin">Minimal Poin</label>
                        <input type="number" name="min_poin" class="form-control" id="" value="{{ $data->min_points }}" placeholder="Masukkan Jumlah Minimal Poin">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Maksimal Poin</label>
                        <input type="number" name="max_poin" class="form-control" id="" value="{{ $data->max_points }}" placeholder="Masukkan Jumlah Maksimal Poin">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                    <label for="deskripsi">Maksimal Hari Peminjaman</label>
                    <div class="input-group mb-3">
                        <input type="number" value="{{ $data->max_borrow_day }}" name="max_hari_peminjaman" class="form-control" placeholder="Masukkan Jumlah Maksimal Hari Peminjaman">
                        <span class="input-group-text" id="basic-addon2">Hari</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="deskripsi">Tanggal Publish</label>
                    <div class="input-group mb-3">
                        <input type="date" name="tanggal_publish" class="form-control" value="{{ $data->publish_date }}" placeholder="Masukkan Tanggal Publish">
                    </div>
                </div>
              </div>
              <div class="row">
                <label for="">Kode Buku</label>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Buku</th>
                                <th>Tanggal Publish</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="" id="append-kode">
                            @foreach ($data->codes as $item)
                            <tr>
                                <input type="hidden" name="old_id_kode[]" value="{{ $item->id }}">
                                <td><input type="text" name="old_kode_buku[]" value="{{ $item->code }}" class="form-control" id="" placeholder="Masukkan Kode Buku"></td>
                                <td><input type="date" name="old_tgl_publish[]" value="{{ $item->publish_date }}" class="form-control" id="" placeholder="Masukkan Tanggal Publish"></td>
                                <td><button type="button" class="btn btn-icon btn-danger remove-kode"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-success" id="add-kode"><i class="fas fa-plus mr-2"></i>Tambah Kode</button>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('master-buku.index') }}" class="btn btn-danger">Kembali</a>
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
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>
  <script>
    $(document).ready(function () {
        var input = document.querySelector('#bookCategoryTags');
        new Tagify(input);
        // Function to append a new row inside the tbody
        $('#add-kode').on('click', function (e) {
            e.preventDefault(); // Prevent default form submission
            let newRow = `<tr>
                            <td><input type="text" name="kode_buku[]" class="form-control" placeholder="Masukkan Kode Buku"></td>
                            <td><input type="date" name="tgl_publish[]" class="form-control" value="{{ date('Y-m-d') }}" placeholder="Masukkan Tanggal Publish"></td>
                            <td><button type="button" class="btn btn-icon btn-danger remove-kode"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
            $('#append-kode').append(newRow); // Append the new row
        });

        // Function to remove the closest row (tr) from the delete button
        $(document).on('click', '.remove-kode', function (e) {
            e.preventDefault(); // Prevent default button behavior
            $(this).closest('tr').remove(); // Remove the closest <tr> from the button
        });

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
                            url: '{{ route('master-buku.update') }}',
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
                                        window.location.href = `{{ route('master-buku.index') }}`;
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
                nama_buku: {
                    required: true,
                    minlength: 3
                },
                sampul: {
                    required: false,
                    extension: "jpg|jpeg|png|webp",
                    filesize: 2 // 2 MB limit
                },
                deskripsi: {
                    required: true,
                    minlength: 10
                },
                min_poin: {
                    required: true,
                    number: true,
                    min: 1
                },
                max_poin: {
                    required: true,
                    number: true,
                    min: 1
                },
                'kode_buku[]': {
                    required: true
                },
                'tgl_publish[]': {
                    required: true,
                    date: true
                },
                max_hari_peminjaman: {
                    required: true,
                    number: true,
                    min: 1
                },
                tanggal_publish: {
                    required: true,
                    date: true
                }
            },
            messages: {
                nama_buku: {
                    required: "Judul Buku harus diisi",
                    minlength: "Judul Buku minimal 3 karakter"
                },
                sampul: {
                    required: "Sampul Buku harus diupload",
                    extension: "Format file harus JPG, JPEG, atau PNG",
                    filesize: "Ukuran file maksimal 2MB"
                },
                deskripsi: {
                    required: "Deskripsi Buku harus diisi",
                    minlength: "Deskripsi minimal 10 karakter"
                },
                min_poin: {
                    required: "Minimal Poin harus diisi",
                    number: "Masukkan angka yang valid",
                    min: "Minimal Poin harus lebih besar dari 0"
                },
                max_poin: {
                    required: "Maksimal Poin harus diisi",
                    number: "Masukkan angka yang valid",
                    min: "Maksimal Poin harus lebih besar dari 0"
                },
                'kode_buku[]': {
                    required: "Kode Buku harus diisi"
                },
                'tgl_publish[]': {
                    required: "Tanggal Publish harus diisi",
                    date: "Masukkan tanggal yang valid"
                },
                max_hari_peminjaman: {
                    required: "Maksimal Hari Peminjaman harus diisi",
                    number: "Masukkan angka yang valid",
                    min: "Maksimal Hari Peminjaman minimal 1 hari"
                },
                tanggal_publish: {
                    required: "Tanggal Publish harus diisi",
                    date: "Masukkan tanggal yang valid"
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
    });


  </script>
@endpush
