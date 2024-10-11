@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Edit Kelas')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Edit Kelas')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row col-12">
      <div class="col-md-8">
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
                <label for="name">Ringkasan</label>
                <div>
                  {{ $peminjaman->review->summary }}
                </div>
              </div>
              <div class="form-group">
                <div>
                  <label for="data_range">Poin:</label>
                  <input type="range" class="form-range w-100" id="data_range" name="data_range" min="{{ $peminjaman->code_book->book->min_points }}" max="{{ $peminjaman->code_book->book->max_points }}" value="{{ $peminjaman->review->points ?? $peminjaman->code_book->book->min_points }}" oninput="updateValue(this)">
                  <p id="value">Value: {{ $peminjaman->review->points ?? $peminjaman->code_book->book->min_points }}</p>
                </div>
              </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" id="btn-submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>

          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Buku</h3>
          </div>
          <!-- /.card-header -->
						@csrf
						@method('PUT')
            <div class="card-body">
              <div>
                <div class="mb-4">
                    <img class="w-100" src="{{ asset($peminjaman->code_book->book->cover) }}" alt="">
                </div>
                <table>
                  <tr>
                    <td>
                        Judul Buku
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $peminjaman->code_book->book->title }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                        Kode Buku
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $peminjaman->code_book->code }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                        Tanggal Dipinjam
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $peminjaman->borrow_date }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                        Tanggal DiKembalikan
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $peminjaman->return_date }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                        Minimal Poin
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $peminjaman->code_book->book->min_points }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                        Maksimal Poin
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $peminjaman->code_book->book->max_points }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                        Deskripsi Buku
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        {{ $peminjaman->code_book->book->description }}
                    </td>
                  </tr>
                </table>
              </div>
            </div>
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
    function updateValue(input) {
        var value = input.value;
        document.getElementById('value').textContent = 'Value: ' + value;
        // You can update the value of $value in your controller or view logic here
    }
</script>
  <script>
    $(function() {
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
                url: '{{ route('peminjaman.poin.update', $peminjaman->id) }}',
                method: 'POST'  ,
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
                      window.location.href = `{{ route('peminjaman.index') }}`;
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
          data_range: {
            required: true,
            number: true,
            min: {{ $peminjaman->code_book->book->min_points }}
          }
        },
        messages: {
          data_range: {
            required: "Poin harus diisi",
            number: "Masukkan angka yang valid",
            min: "Poin minimal {{ $peminjaman->code_book->book->min_points }}"
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
