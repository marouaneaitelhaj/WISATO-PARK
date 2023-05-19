<div class="d-flex w-100 justify-content-evenly">
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Search for Agent') }}</label>
        <input type="search" wire:model="search" class="form-control{{ $errors->has('agent') ? ' is-invalid' : '' }}">
    </div>
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Select Agent') }}</label>

        <select name="agent_id" class="form-select">
            <option  hidden selected>Select Agent</option>
            @foreach ($agents as $agent)
            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
            @endforeach
        </select>
    </div>
</div>