<div class="w-100">
    @if (session()->has('flash_message'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'info',
            html: "{{ session('flash_message') }}"
        });
    </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('show-sweet-alert', event => {
            Swal.fire({
                icon: 'info',
                html: event.detail.message
            });
        });
    </script>
    <div class="w-100 bg-white">
        <h2>
            ParkZone Dashboard:
        </h2>
        <div class="d-flex flex-wrap w-100 justify-content-start align-items-center">
            Quartier:
            <select wire:model="selectedQuartier" class="form-select w-auto" style="border: none;">
                <option value="" selected hidden>{{ $quartiers->first()->quartier_name ?? ''}}</option>
                @foreach($quartiers as $quartier)
                <option value="{{ $quartier->id }}">{{ $quartier->quartier_name }}</option>
                @endforeach
            </select>
            <div class="d-flex">
                <div class="bg-success m-2" >
                    <span class="text-white p-5">Electric</span>
                </div>
                <div class="bg-danger m-2" >
                    <span class="text-white p-5">Gasoline</span>
                </div>
            </div>
        </div>
    </div>
    <div>
        @foreach($parkzones as $parkzone)
        {{ $parkzone->name }}
        @foreach($categories as $categorie)
        @if($categorie->type == 'Electric Car')
        <div class="d-flex flex-wrap bg-white py-5 justify-content-around w-100">
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-success fa-car"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
            @elseif($categorie->type == 'Electric Bike')
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-success fa-bicycle"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
            @elseif($categorie->type == 'Electric Bus')
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-success fa-bus"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
            @elseif($categorie->type == 'Electric Truck')
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-success fa-truck"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
        </div>
        <div class="d-flex flex-wrap  bg-white  py-5 justify-content-around w-100">
            @elseif($categorie->type == 'Gasoline Car')
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-danger fa-car"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
            @elseif($categorie->type == 'Gasoline Bike')
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-danger fa-bicycle"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
            @elseif($categorie->type == 'Gasoline Bus')
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-danger fa-bus"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
            @elseif($categorie->type == 'Gasoline Truck')
            <div class="" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                <i class="fa fa-2x text-danger fa-truck"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
            </div>
        </div>
        @endif
        @endforeach
        @endforeach
    </div>
</div>