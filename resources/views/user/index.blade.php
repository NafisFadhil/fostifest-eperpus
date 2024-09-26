@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'User')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'User')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Data</a>
            <label for="file-import" class="btn btn-success m-0" style="font-weight: normal;">Import Data</label>
						<a class="btn btn-info" href="{{ asset('documents/Format Import User.xlsx') }}">Unduh Format Import</a>
          </div>
          <input class="d-none" type="file" id="file-import" name="file_import" accept=".xlsx">
          <!-- /.card-header -->
          <div class="card-body">
            <table id="myTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Role</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
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
    $(function() {
      var table = $("#myTable").DataTable({
        responsive: true,
        "order": [],
        "ajax": {
          url: '{{ route('user.data') }}',
          type: 'GET',
        },
        "columns": [{
            data: 'name'
          },
          {
            data: 'user_role'
          },
          {
            data: 'action',
          },
        ],
        "columnDefs": [{
            className: 'px-7',
            targets: 0
          },
          {
            targets: -1,
            orderable: false,
            searchable: false,
            // width: "15%"
          }
        ],
      }).buttons().container().appendTo('.card-title');

      // Delete data with sweetalert
      $('#myTable').on('click', '.btn-hapus', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('nama');

        Swal.fire({
          title: "Apakah anda yakin?",
          text: "Untuk menghapus data : " + nama,
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ya, hapus data!",
          cancelButtonText: 'Tidak, batalkan',
          customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: 'btn btn-danger'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Generate the URL using the route() function
            var url = "{{ route('user.destroy', ['user' => ':kode']) }}";
            url = url.replace(':kode',
              kode); // Replace :kode with the actual kode value

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
              type: 'post', // Use the appropriate HTTP method (e.g., 'post' for delete)
              url: url, // Use the generated URL
              data: {
                _method: 'delete', // Laravel expects a _method field for DELETE requests
              },
              dataType: 'json',
              headers: {
                'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
              },
              success: function(response) {
                if (response.status == 'success') {
                  Swal.fire({
                    title: "Berhasil!",
                    text: response.message,
                    icon: "success"
                  }).then(function() {
                    location.reload(true);
                  });
                } else if (response.status == 'error') {
                  Swal.fire("Hapus Data Gagal!", response.message,
                    "error");
                }
              },
              error: function() {
                Swal.fire("ERROR", "Hapus Data Gagal.", "error");
              }
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Batal", "Hapus Data Dibatalkan.", "error");
          }
        });
      });

      //on file-import change
      $('#file-import').change(function() {
        Swal.fire({
          title: 'Apakah anda yakin ingin mengimport data ini?',
          text: 'Proses ini tidak dapat dikembalikan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, import!',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: 'Importing Data',
              html: 'Please wait...',
              didOpen: () => {
                Swal.showLoading()
              },
            })
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
              url: '{{ route('user.import') }}',
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              cache: false,
              success: function(response) {
                Swal.fire({
                  icon: 'success',
                  title: 'Import Sukses',
                  text: response.message,
                }).then(function() {
                  window.location.reload();
                });
                console.log(response);
              },
              error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                  icon: 'error',
                  title: 'Import gagal',
                  html: 'Terjadi kesalahan periksa data dan coba lagi',
                })
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
              }
            });
          }
        })
      });
    });
  </script>
@endpush
