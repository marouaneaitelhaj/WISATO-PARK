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
            <div class="d-flex ml-3 text-center mt-3">
                <div class="bg-primary m-2 rounded-3">
                    <span class="text-white p-3">Electric</span>
                </div>
                <div class="bg-warning m-2 rounded-3">
                    <span class="text-white p-3">Gasoline</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100">
        @foreach ($parkzones as $parkzone)
            <h3 class="text-center pt-5"> {{ $parkzone->name }}</h3>
            <div class="d-flex flex-wrap bg-white py-5 justify-content-around w-100 mt-5 rounded">
                @foreach ($categories as $categorie)
                    <div class="text-center d-flex flex-column" style="cursor: pointer;">
                        @if ($categorie->type == 'Electric Car')
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fa fa-2x text-primary fa-car mb-3 mx-2"></i>
                                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                            </div>
                            <span class="mb-2">Available Slots: </span>
                            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>
                        @elseif($categorie->type == 'Electric Bike')
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fa fa-2x text-primary fa-bicycle  mb-3 mx-2"></i>
                                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                            </div>
                            <span class="mb-2">Available Slots: </span>
                            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>

                        @elseif($categorie->type == 'Electric Bus')
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa fa-2x text-primary fa-bus  mb-3 mx-2"></i>
                            <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                        </div>
                        <span class="mb-2">Available Slots: </span>
                        <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>
                        @elseif($categorie->type == 'Electric Truck')
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa fa-2x text-primary fa-truck  mb-3 mx-2"></i>
                            <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                        </div>
                        <span class="mb-2">Available Slots: </span>
                        <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>
                        @elseif($categorie->type == 'Gasoline Car')
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa fa-2x text-warning fa-car  mb-3 mx-2"></i>
                            <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                        </div>
                        <span class="mb-2">Available Slots: </span>
                        <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>

                        @elseif($categorie->type == 'Gasoline Bike')

                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fa fa-2x text-warning fa-bicycle  mb-3 mx-2"></i>
                                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                            </div>
                            <span class="mb-2">Available Slots: </span>
                            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>


                        @elseif($categorie->type == 'Gasoline Bus')
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa fa-2x text-warning fa-bus  mb-3 mx-2"></i>
                            <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                        </div>
                        <span class="mb-2">Available Slots: </span>
                        <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>

                        @elseif($categorie->type == 'Gasoline Truck')
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa fa-2x text-warning fa-truck  mb-3 mx-2"></i>
                            <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['totalSlots'] }}</span>
                        </div>
                        <span class="mb-2">Available Slots: </span>
                        <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id, $categorie->id)['available'] }}</span>

                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
