<div>
    <div class="w-100">
        @if (session()->has('flash_message'))
        <div class="alert alert-info">
            {!! session('flash_message') !!}
        </div>
        @endif
        <div class="w-100 bg-white rounded-3">
            <h2 class="text-center pt-5">ParkZone Dashboard</h2>
            <label for="quartier" class="mx-4 mb-1">Quartier :</label>

            <div class="d-flex flex-wrap justify-content-center p-3">
                <select id="quartier" wire:model="selectedQuartier" class="form-select">
                    <option value="" selected hidden>{{ $quartiers->first()->quartier_name ?? '' }}</option>
                    @foreach ($quartiers as $quartier)
                    <option value="{{ $quartier->id }}">{{ $quartier->quartier_name }}</option>
                    @endforeach
                </select>
                @if($parkzones != null)
                <select wire:model="selectedParkzone" class="form-select mt-1">
                    <option hidden value="-9" selected>Select Parzone</option>
                    <option value="-1">All</option>
                    @foreach ($parkzones as $index => $prk)
                    <option value="{{ $index }}">{{ $prk->name }}</option>
                    @endforeach
                </select>
                @endif
                <div class="d-flex ml-3 text-center mt-3">
                    <div class="bg-primary m-2 p-2 rounded-3">
                        <span class="text-white p-3">Electric</span>
                    </div>
                    <div class="bg-warning m-2 p-2 rounded-3">
                        <span class="text-white p-3">Gasoline</span>
                    </div>
                    @if($modeshow !== 'all' && $parkzone != null)
                    <div class="bg-success m-2 p-2 rounded-3" style="cursor: pointer;" onclick="showtariff()">
                        @if($parkzone != null)
                        <input type="hidden" id="parkzone_id" value="{{$parkzone->id}}">
                        @else
                        <input type="hidden" id="parkzone_id" value="">
                        @endif
                        <span class="text-white p-3">Show tariff</span>

                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-100">
            @if($parkzone != null)
            <input type="text" value="{{$parkzone_tariff}}" id="tarrif" hidden>
            @if($parkzone->type == 'standard')
            @component('components.standard', ['parkzone' => $parkzone, 'categories' => $categories])
            @endcomponent
            @endif
            @if($parkzone->type == 'floor')
            @component('components.floor', ['parkzone' => $parkzone, 'categories' => $categories])
            @endcomponent
            @endif
            @if($parkzone->type == 'side')
            @component('components.side', ['parkzone' => $parkzone, 'categories' => $categories])
            @endcomponent
            @endif
            @else
            @if($modeshow == 'all')
            @foreach ($parkzones as $parkzone)
            @if($parkzone->type == 'standard')
            @component('components.standard', ['parkzone' => $parkzone, 'categories' => $categories])
            @endcomponent
            @endif
            @if($parkzone->type == 'floor')
            @component('components.floor', ['parkzone' => $parkzone, 'categories' => $categories])
            @endcomponent
            @endif
            @if($parkzone->type == 'side')
            @component('components.side', ['parkzone' => $parkzone, 'categories' => $categories])
            @endcomponent
            @endif
            @endforeach
            @endif
            @endif
        </div>
    </div>
    <script>
        var tariff = [];
        var html = [];

        function showtariff() {
            html = '';
            var parkzone_id = document.getElementById('parkzone_id').value;
            tariff = document.getElementById('tarrif').value;
            tariff = JSON.parse(tariff);
            if (parkzone_id == '') {
                Swal.fire({
                    title: 'Tariff',
                    text: 'Please select a parkzone',
                    icon: 'error',
                });
                return;
            }
            html += '<table class="table table-bordered">';
            html += '<thead>';
            html += '<tr>';
            html += '<th scope="col">Name</th>';
            html += '<th scope="col">Category</th>';
            html += '<th scope="col">Price</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            for (var i = 0; i < tariff.length; i++) {
                if (tariff[i].parkzone_id == parkzone_id) {
                    html += '<tr>';
                    html += '<td>' + tariff[i].name + '</td>';
                    html += '<td>' + tariff[i].category.type + '</td>';
                    html += '<td>' + tariff[i].amount + '</td>';
                    html += '</tr>';
                }
            }
            html += '</tbody>';
            html += '</table>';
            Swal.fire({
                title: 'Tariff',
                html: html,
                icon: 'info',
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showgreenbtn(categorie_id, parkzone_id, type, side = null, floor = null) {
            axios.get("api/parkingSlotapi/" + parkzone_id + "/" + categorie_id + "/" + type + "/" + side + "/" + floor)
                .then(function(response) {
                    if (response.data == 0) {
                        Swal.fire({
                            title: 'Parking Slot',
                            text: 'No parking slot available',
                            icon: 'error',
                        });
                    } else {
                        html = '';
                        html += '<div class="d-flex justify-content-around flex-wrap">';
                        for (var i = 0; i < response.data["slots"].length; i++) {
                            if (response.data["slots"][i] != []) {
                                html += '<div class="col-2 m -2">';
                                if (response.data["slots"][i].active_parking == null) {
                                    html += '<button class="btn btn-success" onclick="showparkingmodal(' + response.data["slots"][i].id + ',' + categorie_id + ', \'' + type + '\')">';
                                } else {
                                    html += '<button class="btn btn-danger" disabled onclick="showparkingmodal(' + response.data["slots"][i].id + ',' + categorie_id + ', \'' + type + '\')">';
                                }
                                html += response.data["slots"][i].name;
                                html += '</button>';
                                html += '</div>';
                            }
                        }
                        html += '</div>';
                        Swal.fire({
                            title: 'Parking Slot',
                            html: html,
                            icon: 'info',
                        });
                        console.log(response.data);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                })
                .then(function() {
                    // always executed
                });
        }

        function showparkingmodal(slot_id, category, type) {
            // show parking modal as form have Vehicle No input, Driver Mobile input,  Driver name input
            html = '';
            html += '<div class="form-group">';
            html += '<label for="vehicle_no">Vehicle No</label>';
            html += '<input type="text" class="form-control" id="vehicle_no" placeholder="Enter Vehicle No">';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label for="driver_mobile">Driver Mobile</label>';
            html += '<input type="text" class="form-control" id="driver_mobile" placeholder="Enter Driver Mobile">';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label for="driver_name">Driver Name</label>';
            html += '<input type="text" class="form-control" id="driver_name" placeholder="Enter Driver Name">';
            html += '</div>';
            Swal.fire({
                title: 'Parking',
                html: html,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Park',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    var vehicle_no = document.getElementById('vehicle_no').value;
                    var driver_mobile = document.getElementById('driver_mobile').value;
                    var driver_name = document.getElementById('driver_name').value;
                    if (vehicle_no == '' || driver_mobile == '' || driver_name == '') {
                        Swal.fire({
                            title: 'Parking',
                            text: 'Please fill all fields',
                            icon: 'error',
                        });
                        return;
                    }
                    axios.post("/parking", {
                            slot_id: slot_id,
                            vehicle_no: vehicle_no,
                            driver_mobile: driver_mobile,
                            driver_name: driver_name,
                            category_id: category,
                            tableName: type,

                        })
                        .then(function(response) {
                            console.log(response.data);
                            document.querySelector("body").innerHTML = ""
                            document.querySelector("body").innerHTML = response.data;
                        })
                        .catch(function(error) {
                            Swal.fire({
                                title: 'Parking',
                                text: 'Something went wrong',
                                icon: 'error',
                            });
                        })
                        .then(function() {
                            // always executed
                        });
                }
            })
        }
    </script>
</div>