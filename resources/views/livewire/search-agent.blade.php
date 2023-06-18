<div>
    <div class=" form-group">
        @if (session()->has('flash_message'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: '{{ session('
                flash_message.type ') }}',
                text: '{{ session('
                flash_message.message ') }}'
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
        <label for="operator">Agent</label>
        <select wire:model="selectedAgent" name="agent_id[]" id="operator" multiple>
            @foreach ($agents as $agent)
            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
            @endforeach
        </select>
        @error('agent_id') <span class="text-danger">{{ $message }}</span> @enderror



    </div>

    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('operator'); // id
        // document.querySelectorAll('.input-container')[0].addEventListener('click', function() {
        //     document.querySelectorAll('.drawer')[0].classList.toggle('hidden');
        // });
    </script>

</div>