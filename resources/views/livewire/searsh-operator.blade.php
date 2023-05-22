<div class="d-flex w-100 justify-content-evenly">
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Search for Operator') }}</label>
        <input type="search" wire:model="search" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}"
            name="operator">
    </div>
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Select Operator') }}</label>
        <div class="d-flex">

        @foreach ($operators as $operator)

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="operator[]" value="{{ $operator->id }}"
                        id="{{ $operator->id }}">
                    <label class="form-check-label" for="{{ $operator->id }}">
                        {{ $operator->name }}
                    </label>
                </div>
        @endforeach
    </div>

    </div>
</div>
