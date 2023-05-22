<div class="d-flex w-100 justify-content-evenly">
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Search for Operator') }}</label>
        <input type="search" wire:model="search" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}"
            name="operator">
    </div>
    <div class="form-group w-100 mx-4">
        <label for="identity" class="text-md-right">{{ __('Select Operator') }}</label>


        <div class="form-check" id="operatorContainer">
            @foreach ($operators as $index => $operator)
                <div class="form-check-inline" style="{{ $index >= 3 ? 'display:none;' : '' }}">
                    <input class="form-check-input" type="checkbox" name="operator[]" value="{{ $operator->id }}"
                        id="{{ $operator->id }}">
                    <label class="form-check-label" for="{{ $operator->id }}">
                        {{ $operator->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button id="showMoreBtn" class="btn btn-primary" type="button">Show More</button>
        <button id="showLessBtn" class="btn btn-primary" type="button" style="display: none;">Show Less</button>





    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#showMoreBtn').on('click', function() {
                $('.form-check-inline').show();
                $(this).hide();
                $('#showLessBtn').show();
            });

            $('#showLessBtn').on('click', function() {
                $('.form-check-inline:gt(2)').hide();
                $(this).hide();
                $('#showMoreBtn').show();
            });
        });
    </script>
</div>
