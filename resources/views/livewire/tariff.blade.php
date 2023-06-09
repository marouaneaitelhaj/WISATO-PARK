    @if (session()->has('flash_message'))
    <div class="alert alert-info">
        {!! session('flash_message') !!}
    </div>
    @endif

    {{-- <div class="d-flex">


    <div class="form-group row">
        <label for="quartier_id" class="col-md-4 col-form-label text-md-right">{{ __('Quartier ') }}<span class="tcr i-req">*</span> </label>
        <div class="col-md-8">

        <select name="quartier_id" id="quartier_id" wire:model="selectedQuartier" class="form-control{{ $errors->has('quartier_id') ? ' is-invalid' : '' }}" required>
            <option value="" selected hidden>{{ $quartiers->first()->quartier_name ?? '' }}</option>
            @foreach ($quartiers as $quartier)
            <option value="{{ $quartier->id }}">{{ $quartier->quartier_name }}</option>
            @endforeach
        </select>
        @if ($errors->has('quartier_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('quartier_id') }}</strong>
        </span>
        @endif
        </div>

    </div>



    <div class="form-group row">
        <label for="parkzone_id" class="col-md-4 col-form-label text-md-right">{{ __('Parkzone') }}<span class="tcr i-req">*</span> </label>
        <div class="col-md-8">
            <select name="parkzone_id" id="parkzone_id" wire:model="selectedParkzone" class="form-control{{ $errors->has('parkzone_id') ? ' is-invalid' : '' }}" required>
                <option hidden value="" selected>Select Parkzone</option>
                @foreach ($parkzones as $index => $prk)
                <option value="{{ $prk->id }}">{{ $prk->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('parkzone_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('parkzone_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
 --}}


 {{-- <div class="d-flex flex-wrap flex-sm-nowrap flex-md-wrap"> --}}



    {{-- my --}}
 {{-- <div class="d-flex flex-row">
    <div class="form-group w-100 d-flex align-items-center">
        <label class="col-md-6 col-form-label text-md-right" for="quartier_id">{{ __('Quartier') }}<span class="tcr i-req">*</span></label>
        <select name="quartier_id" id="quartier_id" wire:model="selectedQuartier" class="mx-2 form-control{{ $errors->has('quartier_id') ? ' is-invalid' : '' }}" required>
            <option value="" selected hidden>{{ $quartiers->first()->quartier_name ?? '' }}</option>
            @foreach ($quartiers as $quartier)
                <option value="{{ $quartier->id }}">{{ $quartier->quartier_name }}</option>
            @endforeach
        </select>
        @if ($errors->has('quartier_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('quartier_id') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group w-50 d-flex align-items-center">
        <label class="mx-2" for="parkzone_id">{{ __('Parkzone') }}<span class="tcr i-req">*</span></label>
        <select name="parkzone_id" id="parkzone_id" wire:model="selectedParkzone" class="form-control{{ $errors->has('parkzone_id') ? ' is-invalid' : '' }}" required>
            <option hidden value="" selected>Select Parkzone</option>
            @foreach ($parkzones as $index => $prk)
                <option value="{{ $prk->id }}">{{ $prk->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('parkzone_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('parkzone_id') }}</strong>
            </span>
        @endif
    </div>
</div>
 --}}














 <div>
    <div class="d-flex flex-row">
        <div class="form-group w-100 d-flex align-items-center">
            <label class="col-md-6 col-form-label text-md-right" for="quartier_id">{{ __('Quartier') }}<span class="tcr i-req">*</span></label>
            <select name="quartier_id" id="quartier_id" wire:model="selectedQuartier" class="mx-2 form-control{{ $errors->has('quartier_id') ? ' is-invalid' : '' }}" required>
                <option value="" selected hidden>{{ $quartiers->first()->quartier_name ?? '' }}</option>
                @foreach ($quartiers as $quartier)
                    <option value="{{ $quartier->id }}">{{ $quartier->quartier_name }}</option>
                @endforeach
            </select>
            @if ($errors->has('quartier_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('quartier_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group w-50 d-flex align-items-center">
            <label class="mx-2" for="parkzone_id">{{ __('Parkzone') }}<span class="tcr i-req">*</span></label>
            <select name="parkzone_id" id="parkzone_id" wire:model="selectedParkzone" class="form-control{{ $errors->has('parkzone_id') ? ' is-invalid' : '' }}" required>
                <option hidden value="" selected>Select Parkzone</option>
                @foreach ($parkzones as $index => $prk)
                    <option value="{{ $prk->id }}">{{ $prk->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('parkzone_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('parkzone_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
