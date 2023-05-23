<div class="d-flex justify-content-evenly flex-wrap flex-sm-nowrap">
    <div class="form-group w-100">
        <label for="identity" class="text-md-right">{{ __('Search for Agent') }}</label>
        <input type="search" wire:model="search" class="form-control{{ $errors->has('agent') ? ' is-invalid' : '' }}">
    </div>
    <div class="form-group w-100">
        <label for="identity" class="text-md-right">{{ __('Select Agent') }}</label>

        <select name="agent_id" class="form-control">
            <option  hidden selected>Select Agent</option>
            @foreach ($agents as $agent)
            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
            @endforeach
        </select>
    </div>
</div>