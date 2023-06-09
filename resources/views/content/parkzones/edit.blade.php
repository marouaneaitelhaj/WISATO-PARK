@extends('layouts.app')
@section('title', ' - Edit ParkZone')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit ParkZone') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parkzones.index') }}">ParkZone List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('parkzones.update',['parkzone' => $parkzone->id]) }}">
                        @csrf   
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="text-md-right">{{ __('Name') }} <span class="tcr text-danger">*</span></label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $parkzone->name }}" autocomplete="off" autofocus>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 w-100">
                                @livewire('search-agent', ['parkzone' => $parkzone])
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mode" class="text-md-right">{{ __('Mode') }} <span class="tcr text-danger">*</span></label>
                                    <!-- <input id="mode" type="text" class="form-control{{ $errors->has('mode') ? ' is-invalid' : '' }}" name="mode" value="{{ old('mode') }}" autocomplete="off" autofocus> -->
                                    <select name="mode" class="form-select" id="mode" class="form-select">
                                        <option value="{{ $parkzone->mode }}" selected hidden>{{ $parkzone->mode }}</option>
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                    @if ($errors->has('mode'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="type" class="text-md-right">{{ __('Type') }} <span class="tcr text-danger">*</span></label>
                                    <select name="type" class="form-select" id="type">
                                    <option value="{{ $parkzone->type }}" selected hidden>{{ $parkzone->type }}</option>
                                        <option value="standard">Standard</option>
                                        <option value="floor">Floor</option>
                                        <option value="side">Side</option>
                                    </select>
                                    @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks" class="text-md-right">{{ __('Remarks') }}</label>
                                    <textarea name="remarks"  id="remarks" class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}" rows="2">{{ $parkzone->remarks }}</textarea>
                                    @if ($errors->has('remarks'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('remarks') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 d-none">
                                <div class="form-group d-flex justify-content-around ">
                                    <div>
                                        {{-- <label for="name" class="text-md-right">{{ __('lng') }}</label> --}}
                                        <input type="hidden" id="lng" value="{{$parkzone->lng}}" name="lng" class="form-control" readonly />
                                    </div>
                                    <div>
                                        {{-- <label for="name" class="text-md-right">{{ __('lat') }}</label> --}}
                                        <input type="hidden" id="lat" name="lat" value="{{$parkzone->lat}}" class="form-control" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @livewire('quartier-city', ['quartier' => $quartier->quartier_name, 'parkzone' => $parkzone])
                               
                                
                            </div>
                            <div class="col-md-12">
                                <div class="form-group d-flex justify-content-around ">
                                    <div id="map"></div>
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
        width: 100%;
        height: 300px;
    }
</style>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
<script src='https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js' crossorigin=''></script>
<link rel='stylesheet' href='https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css' crossorigin='' />

<script>
    var selectedcity = '';
    var selectedquartier = '';
    document.getElementById("city").addEventListener('change', function(e) {
        var selectedOption = e.target.options[e.target.selectedIndex];
        selectedcity = selectedOption.textContent;
        console.log(selectedcity);
        fetch('https://nominatim.openstreetmap.org/search?q=' + selectedcity + '&limit=1&format=json&addressdetails=1')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById("lat").value = data[0].lat;
                document.getElementById("lng").value = data[0].lon;
                map.setView([data[0].lat, data[0].lon], 15);
            });
    })
    document.getElementById("quartier").addEventListener('change', function(e) {

    })
    document.getElementById("quartier").addEventListener("change", function(e) {
        // i want to get the selected option text and add it to the url with the city text
        var selectedOption = e.target.options[e.target.selectedIndex];
        selectedquartier = selectedOption.textContent;
        console.log(selectedquartier);
        // change spaCE TO +
        selectedquartier = selectedquartier.replace(/ /g, '+');
        fetch('https://nominatim.openstreetmap.org/search?q=' + selectedquartier + '+' + selectedcity + '&limit=1&format=json&addressdetails=1')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById("lat").value = data[0].lat;
                document.getElementById("lng").value = data[0].lon;
                map.setView([data[0].lat, data[0].lon], 15);
            });

    })
    let map, markers = [];
    let circle;
    let isSatelliteView = false;

    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = L.map('map', {
            center: {
                lat: "<?php echo $parkzone->lat ?>",
                lng: "<?php echo $parkzone->lng ?>",
            },
            zoom: 15
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            // attribution: '© OpenStreetMap'
        }).addTo(map);

        map.on('click', mapClicked);

        // Add geocoder control for search functionality 
        L.Control.geocoder().addTo(map);

        // Create the "Find My Location" icon and position it in the middle of the map
        const findLocationIcon = L.control({
            position: 'topright'
        });

        findLocationIcon.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            div.innerHTML = '<a href="#" title="Find My Location" onclick="findMyLocation(); return false;"><i class="fa fa-location-arrow"></i></a>';
            return div;
        };

        findLocationIcon.addTo(map);

        // Create the "Toggle View" icon and position it in the bottom right corner of the map
        const toggleViewIcon = L.control({
            position: 'bottomright'
        });

        satelliteViewIcon.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            div.innerHTML = '<a href="#" title="Toggle View" onclick="toggleView(); return false;"><i id="toggle-icon" class="fa fa-globe"></i></a>';
            return div;
        };

        toggleViewIcon.addTo(map);
    }
    initMap();

    /* --------------------------- Initialize Markers --------------------------- */

    function generateMarker(data, index) {
        return L.marker(data.position)
    }

    /* ------------------------- Handle Map Click Event ------------------------- */

    function mapClicked($event) {
        const data = {
            position: $event.latlng,
            draggable: true
        }

        if (markers.length > 0) {
            markers.forEach(marker => marker.remove());
        }

        const marker = generateMarker(data, markers.length);
        marker.addTo(map);
        markers.push(marker);
        document.getElementById('lat').value = $event.latlng.lat;
        document.getElementById('lng').value = $event.latlng.lng;

        // Remove previous circle if it exists
        if (circle) {
            circle.remove();
        }

        // Create a circle with a radius of 50 meters around the clicked location
        circle = L.circle($event.latlng, {
            color: 'blue',
            fillColor: 'blue',
            fillOpacity: 0.3,
            radius: 50
        }).addTo(map);
    }

    /* ------------------------ Find My Location ----------------------- */
    function findMyLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    document.getElementById('lat').value = latitude;
                    document.getElementById('lng').value = longitude;

                    // Center the map to the current location
                    map.setView([latitude, longitude], 15);

                    // Remove previous circle if it exists
                    if (circle) {
                        circle.remove();
                    }

                    // Create a circle with a radius of 50 meters around the current location
                    circle = L.circle([latitude, longitude], {
                        color: 'blue',
                        fillColor: 'blue',
                        fillOpacity: 0.3,
                        radius: 50
                    }).addTo(map);
                },
                error => {
                    console.error('Error getting location:', error.message);
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }

    /* ------------------------ Toggle View ----------------------- */

    function toggleView() {
        if (isSatelliteView) {
            switchToNormalMap();
        } else {
            switchToSatelliteView();
        }
    }

    function switchToSatelliteView() {
        const tileLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google'
        });

        if (!map.hasLayer(tileLayer)) {
            map.addLayer(tileLayer);
            document.getElementById('toggle-icon').classList.remove('fa-globe');
            document.getElementById('toggle-icon').classList.add('fa-map');
        }

        isSatelliteView = true;
    }

    function switchToNormalMap() {
        const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        });

        if (!map.hasLayer(tileLayer)) {
            map.addLayer(tileLayer);
            document.getElementById('toggle-icon').classList.remove('fa-map');
            document.getElementById('toggle-icon').classList.add('fa-globe');
        }

        isSatelliteView = false;
    }
</script>
@livewireScripts
@endsection