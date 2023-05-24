<div class="border form-group">
    <div class="d-flex border w-100 justify-content-evenly">
        <div class="w-100 d-flex">
            <ul class="d-flex" style="list-style: none;">
                @foreach ($selectedAgents as $index => $agent)
                <li class="bg-success px-2 m-1 py-1 rounded">{{ $agent['name'] }}</li>
                @endforeach
            </ul>
            <input type="text" style="border: none;" wire:model="search" class="form-control{{ $errors->has('agent') ? ' is-invalid' : '' }}" name="agent">
        </div>
    </div>
    <div class="w-100">
        <div class="border">
            @foreach ($agents as $index => $agent)
            <div wire:click="selectAgent({{ $agent->id }})" class="border">
                <p>{{ $agent->name }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
