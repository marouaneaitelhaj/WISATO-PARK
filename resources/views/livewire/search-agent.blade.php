<div class="border form-group">
    @if (session()->has('flash_message'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: '{{ session('flash_message.type') }}',
                text: '{{ session('flash_message.message') }}'
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('show-sweet-alert', event => {
            Swal.fire({
                icon: event.detail.type,
                text: event.detail.message
            });
        });
    </script>

    <div class="d-flex flex-wrap border w-100 justify-content-between align-items-center">
        <ul class="d-flex flex-wrap list-unstyled m-0">
            @foreach ($selectedAgents as $index => $agent)
                <li style="background-color: #2dce89;" class="px-2 m-1 py-1 rounded d-flex">
                    <div>
                        {{ $agent['name'] }}
                    </div>
                    <a type="button" wire:click="removeAgent({{ $index }})" class="" style="color: azure"><i
                            class="fa fa-minus-circle mx-1" aria-hidden="true"></i>
                    </a>
                    <input type="text" hidden value="{{$agent['id']}}" name="agent_id[]">

                </li>
            @endforeach
            <input type="text" style="border: none;" wire:model="search" class="flex-grow-1">
        </ul>
    </div>
    <div class="w-100">
        <div class="border">

            <div class="border">
                @foreach ($agents as $index => $agent)
                <div wire:click="selectAgent({{$agent->id}})" style="cursor: pointer;" class="border tags d-flex align-items-center">
                    <span>
                        {{$agent->name}}
                    </span>
                </div>
                @endforeach
                
            </div>
            
        </div>
    </div>
</div>

<style>
    .tags {
        padding: 5px 10px;
        border-radius: 5px;
        margin: 5px;
    }

    .tags:hover {
        background-color: #2dce89;
        color: white;
    }

    .tags span {
        font-size: 14px;
    }
</style>