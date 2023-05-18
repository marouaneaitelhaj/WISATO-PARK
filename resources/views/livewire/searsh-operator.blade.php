<div class="d-flex w-100 justify-content-evenly">
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Search for Operator') }}</label>
        <input type="search" wire:model="search" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}" name="operator">
    </div>
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Select Operator') }}</label>

        <select name="operator" class="form-select">
            <option  hidden selected>Select Operator</option>
            @foreach ($operators as $operator)
            <option value="{{ $operator->id }}">{{ $operator->name }}</option>
            @endforeach
        </select>
    </div>
</div>