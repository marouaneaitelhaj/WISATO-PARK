<div>
    @if (session()->has('flash_message'))
    <div class="alert alert-info">
        {!! session('flash_message') !!}
    </div>
    @endif



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
