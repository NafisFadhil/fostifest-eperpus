@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Buku')
@section('content_header_title', 'Master Data')
@section('content_header_subtitle', 'Buku')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-0 ps-10">
                        <div class="row g-8 align-items-end">
                            <div class="col-lg-2">
                                <a href="{{ route('master-buku.create') }}" class="btn btn-success me-5 mt-2" >
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Buku Baru
                                </a>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-label">Kategori</div>
                                <select name="kelas" class="form-control select2" data-dropdown-css-class=""
                                        style="width: 100%;" id="kategori" data-placeholder="Kategori" placeholder="Kategori">
                                    <option value="all" selected>Semua Kategori</option>
                                    @foreach ($data_category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Button filter --}}
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-primary me-5 mt-2" id="filter-table">
                                    <i class="fas fa-search"></i>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Sampul</th>
                                <th>Deskripsi</th>
                                <th>Max Hari Peminjaman</th>
                                <th>Kategori</th>
                                <th>Tanggal Publish</th>
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
    $(function () {
        var table = $("#myTable").DataTable({
            responsive: true,
            "order": [],
            "ajax": {
                url: '{{ route('master-buku.data') }}',
                type: 'GET',
                data: function (d) {
                    d.category = $('#kategori').val(); // Pass the selected category to the server
                }
            },
            "columns": [
                { data: 'title' },
                { data: 'image' },
                { data: 'description' },
                { data: 'max_borrow_day' },
                { data: 'categories_name' },
                { data: 'publish_date' },
                { data: 'action' }
            ]
        });

        // Filter data
        $("#filter-table").on('click', function () {
            // Reload the DataTable with the selected filter
            table.ajax.reload();  // Re-fetch data from server with the new filter
        });
    });
    $(document).on('click', '.btn-hapus', function() {
    var bookId = $(this).data('id');
    var bookName = $(this).data('nama');

    // Show confirmation dialog using SweetAlert
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete the book "' + bookName + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the deletion via AJAX
            $.ajax({
                url: '/buku/delete/' + bookId,  // URL for the delete route
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"  // Pass the CSRF token for security
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            // Optionally refresh the table or remove the deleted row
                            location.reload(); // Refresh the page to see changes
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'There was a problem deleting the book. Please try again later.',
                        'error'
                    );
                }
            });
        }
    });
});

</script>
@endpush
