@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Izin')
@section('content_header_title', 'Master Absensi')
@section('content_header_subtitle', 'Izin')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('master-izin.create') }}" class="btn btn-primary">Tambah Data</a>
          </div>
          <div class="card-body border-0 ps-10">
            <div class="row g-8 align-items-end">
              <div class="col-lg-2">
                <div class="form-label">Tanggal Awal</div>
                <input type="date" name="date_start" id="date_start" class="form-control flatpickr-input"
                  placeholder="Tanggal Awal" value="{{ date('Y-m-01') }}">
              </div>
              <div class="col-lg-2">
                <div class="form-label">Tanggal Akhir</div>
                <input type="date" name="date_end" id="date_end" class="form-control flatpickr-input"
                  placeholder="Tanggal Akhir" value="{{ date('Y-m-t') }}">
              </div>

              <div class="col-lg-3">
                <button type="button" class="btn btn-primary me-5 mt-2" id="filter-table">
                  <i class="fas fa-search"></i>
                  Cari
                </button>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="myTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Tanggal Izin</th>
                  <th>Durasi Izin</th>
                  <th>Keterangan</th>
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
          url: '{{ route('master-izin.data') }}',
          type: 'GET',
        },
        "columns": [{
            data: 'siswa'
          },
          {
            data: 'tanggal',
          },
          {
            data: 'durasi',
          },
          {
            data: 'keterangan',
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
      });

      // Filter data
      $("#filter-table").on('click', function() {
        var date_start = $("#date_start").val();
        var date_end = $("#date_end").val();

        // Update the DataTable with the selected filters
        table.ajax.url('{{ route('master-izin.data') }}' + '?date_start=' + date_start +
          '&date_end=' +
          date_end).load();
      });

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
            var url = "{{ route('master-izin.destroy', ['master_izin' => ':kode']) }}";
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
