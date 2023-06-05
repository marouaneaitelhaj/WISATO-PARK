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
   <div class="w-100 bg-white rounded-3">
    <h2 class="text-center pt-5">ParkZone Dashboard</h2>
    <div class="d-flex flex-wrap justify-content-start align-items-center p-3">
        <label for="quartier" class="mr-2 mb-3">Quartier :</label>
        <select id="quartier" wire:model="selectedQuartier" class="form-select">
            <option value="" selected hidden>{{ $quartiers->first()->quartier_name ?? ''}}</option>
            @foreach($quartiers as $quartier)
            <option value="{{ $quartier->id }}">{{ $quartier->quartier_name }}</option>
            @endforeach
        </select>
        <div class="d-flex ml-3">
            <div class="bg-success m-2">
                <span class="text-white p-3">Electric</span>
            </div>
            <div class="bg-danger m-2">
                <span class="text-white p-3">Gasoline</span>
            </div>
        </div>
    </div>
</div>

    <div class="w-100">
        @foreach($parkzones as $parkzone)
        <div class="d-flex flex-wrap bg-white py-5 justify-content-around w-100 mt-5 rounded-pill">
            @foreach($categories as $categorie)
            <div class="text-center d-flex flex-column" wire:click="disponible({{$parkzone->id}}, {{$categorie->id}})" style="cursor: pointer;">
                @if($categorie->type == 'Electric Car')
                <i class="fa fa-2x text-success fa-car"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @elseif($categorie->type == 'Electric Bike')
                <i class="fa fa-2x text-success fa-bicycle"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @elseif($categorie->type == 'Electric Bus')
                <i class="fa fa-2x text-success fa-bus"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @elseif($categorie->type == 'Electric Truck')
                <i class="fa fa-2x text-success fa-truck"></i>
                <span class="text-success">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @elseif($categorie->type == 'Gasoline Car')
                <i class="fa fa-2x text-danger fa-car"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @elseif($categorie->type == 'Gasoline Bike')
                <i class="fa fa-2x text-danger fa-bicycle"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @elseif($categorie->type == 'Gasoline Bus')
                <i class="fa fa-2x text-danger fa-bus"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @elseif($categorie->type == 'Gasoline Truck')
                <i class="fa fa-2x text-danger fa-truck"></i>
                <span class="text-danger">{{$this->getNumberOfSlots($parkzone->id, $categorie->id)}}</span>
                @endif
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
