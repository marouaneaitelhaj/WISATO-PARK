@extends('layouts.app')
@section('title', ' - Create New Floor')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Create ParkZone') }}
                    <a class="btn btn-sm btn-info pull-right" href="{{ route('floors.index') }}">ParkZone List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('floors.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="text-md-right">{{ __('Name') }} <span class="tcr text-danger">*</span></label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autocomplete="off" autofocus>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="level" class="text-md-right">{{ __('Floor Level') }}</label>
                                    <select name="level" id="level" class="form-control{{ $errors->has('level') ? ' is-invalid' : '' }}" required>
                                        @for ($i = 0; $i <= 12; $i++ )
                                            <option value="{{ $i }}" {{ (old('level')== $i ) ? ' selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    
                                    @if ($errors->has('level'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="text-md-right">{{ __('Remarks') }}</label>
                                    <textarea name="remarks" id="remarks" class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}" rows="2"></textarea>
                                    @if ($errors->has('remarks'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('remarks') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group d-flex justify-content-around ">
                                    <div>
                                        <label for="name" class="text-md-right">{{ __('lng') }}</label>
                                        <input type="number" id="lng" class="form-control" />
                                    </div>
                                    <div>
                                        <label for="name" class="text-md-right">{{ __('lat') }}</label>
                                        <input type="number"  id="lat" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="pull-right">
                                    <button type="reset" class="btn  btn-secondary me-2" id="frmClear">
                                        {{ __('Clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .text-center {
        text-align: center;
    }

    #map {
        width: '100%';
        height: 100vh;
    }
</style>

<div id='map'></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />

<script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
<script>
    let map, markers = [];
    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = L.map('map', {
            center: {
                lat: 28.626137,
                lng: 79.821603,
            },
            zoom: 15
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        map.on('click', mapClicked);
        initMarkers();
    }
    initMap();

    /* --------------------------- Initialize Markers --------------------------- */


    function generateMarker(data, index) {
        return L.marker(data.position, {
                draggable: data.draggable
            })
            .on('click', (event) => markerClicked(event, index))
            .on('dragend', (event) => markerDragEnd(event, index));
    }

    /* ------------------------- Handle Map Click Event ------------------------- */
    function mapClicked($event) {
        const data = {
            position: $event.latlng,
            draggable: true
        }
        const marker = generateMarker(data, markers.length - 1);
        marker.addTo(map).bindPopup(`<b>${data.position.lat},  ${data.position.lng}</b>`);
        markers = marker;
        document.getElementById('lat').value = $event.latlng.lat;
        
        document.getElementById('lng').value = $event.latlng.lng;
    }

    /* ------------------------ Handle Marker Click Event ----------------------- */
    function markerClicked($event, index) {
        // console.log(map);
        // console.log($event.latlng.lat, $event.latlng.lng);
        console.log("slajdaskljdklj");
        
    }

    /* ----------------------- Handle Marker DragEnd Event ---------------------- */
    function markerDragEnd($event, index) {
        console.log(map);
        console.log($event.target.getLatLng());
    }
    const data = {
        position: {
            lat: 28.625043,
            lng: 79.810135
        },
        draggable: true
    }
    const marker = generateMarker(data, markers.length - 1);
    marker.addTo(map).bindPopup(`<b>${data.position.lat},  ${data.position.lng}</b>`);
    markers.push(marker);
</script>


@endsection