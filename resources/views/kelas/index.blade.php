@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kelas')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Kelas')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Data</a>
            <h3 class="card-title"></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="myTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama</th>
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
          url: '{{ route('kelas.data') }}',
          type: 'GET',
        },
        "columns": [{
            data: 'name'
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
            var url = "{{ route('kelas.destroy', ['kelas' => ':kode']) }}";
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
    });
  </script>
@endpush
