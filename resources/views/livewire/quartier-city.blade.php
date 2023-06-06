<div class="form-group">
    <label class="text-md-right">Address</label>
    <select class="form-select m-1" id="city" wire:model="selectedCity" name="" id="">
        <option value="" hidden>-- Choisir une ville --</option>
        @foreach ($cities as $city)
        <option value="{{ $city->id }}">{{ $city->CITY }}</option>
        @endforeach
    </select>
    <select class="form-select m-1{{ $errors->has('quartier_id') ? ' is-invalid' : '' }}" id="quartier" wire:model="selectedQuartier" name="quartier_id" id="">
        <option value="" hidden>-- Choisir un quartier --</option>
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