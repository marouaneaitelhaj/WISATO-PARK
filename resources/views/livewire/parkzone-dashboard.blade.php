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
            <select wire:model="selectedParkzone" class="form-select mt-1">
                <option hidden value="-9" selected>Select Parzone</option>
                @foreach ($parkzones as $index => $prk)
                <option value="{{ $index }}">{{ $prk->name }}</option>
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
        @if($parkzone != null)
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
        @endif
    </div>
</div>