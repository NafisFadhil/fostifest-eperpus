@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Pengaturan')
@section('content_header_title', 'Admin')
@section('content_header_subtitle', 'Pengaturan')

{{-- Content body: main page content --}}

@section('content_body')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-header -->
          <form id="quickForm">
            <div class="card-body">
              @foreach ($settings as $item)
                @if ($item->input_type == 'leaflet')
                  <div class="form-group">
                    <label for="{{ $item->key }}">{{ $item->label }}</label>
                    <input type="hidden" name="setting[{{ $item->key }}]" class="form-control" id="{{ $item->key }}"
                      placeholder="Masukkan {{ $item->label }}" value="{{ $item->value }}">
                    <div id="map" style="height: 300px"></div>
                  </div>
                  @push('js')
                    <script>
                      var map = L.map('map').setView([{{ $item->value }}], 19);
                      var circle = new L.circleMarker();
                      circle = new L.circle([{{ $item->value }}], {
                        color: 'blue',
                        fillColor: '#00a2e9',
                        fillOpacity: 0.5,
                        radius: 50
                      }).addTo(map);
                      L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                      }).addTo(map);
                      var searchControl = new L.esri.Controls.Geosearch().addTo(map);
                      var results = new L.LayerGroup().addTo(map);
                      searchControl.on('results', function(data) {
                        results.clearLayers();
                        for (var i = data.results.length - 1; i >= 0; i--) {
                          results.addLayer(L.marker(data.results[i].latlng));
                        }
                      });
                      map.on('click', function(e) {
                        map.removeLayer(circle);
                        circle = new L.circle([e.latlng.lat, e.latlng.lng], {
                          color: 'blue',
                          fillColor: '#00a2e9',
                          fillOpacity: 0.5,
                          radius: 50
                        }).addTo(map);

                        map.setView([e.latlng.lat, e.latlng.lng], 20)

                        $('input[name="setting[{{ $item->key }}]"]').val(e.latlng.lat + ", " + e.latlng.lng);
                      });
                    </script>
                  @endpush
                @else
                  <div class="form-group">
                    <label for="{{ $item->key }}">{{ $item->label }}</label>
                    <input type="{{ $item->input_type }}" name="setting[{{ $item->key }}]" class="form-control"
                      id="{{ $item->key }}" placeholder="Masukkan {{ $item->label }}" value="{{ $item->value }}">
                  </div>
                @endif
              @endforeach
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
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
      var form = $('#quickForm');
			$('#btn-submit').on('click', function(e) {
				e.preventDefault();
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
							url: '{{ route('setting.store') }}',
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
											`{{ route('setting.index') }}`;
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
			});
    });
  </script>
@endpush
