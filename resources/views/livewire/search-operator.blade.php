<div class="d-flex w-100 justify-content-evenly">
    <div class="form-group w-100">
        <label for="identity" class="text-md-right">{{ __('Search for Operator') }}</label>
        <input type="search" wire:model="search" class="form-control{{ $errors->has('operator') ? ' is-invalid' : '' }}" name="operator">
    </div>
    <div class="form-group w-100">
        <label for="identity" class="text-md-right">{{ __('Select Operator') }}</label>
        <div class="d-flex flex-wrap justify-content-around">
            <div class="form-check" id="operatorContainer">
                @foreach ($operators as $index => $operator)
                    {{-- <div class="form-check-inline" style="{{ $index >= 3 ? 'display:none;' : '' }}">
                        <input class="form-check-input" type="checkbox" name="operator[]" value="{{ $operator->id }}" id="{{ $operator->id }}">
                        <label class="form-check" for="{{ $operator->id }}">{{ $operator->name }}</label>
                    </div> --}}

                    
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="operator[]" value="{{ $operator->id }}" id="{{ $operator->id }} class="custom-control-input" id="customCheckBox1">
                        <label class="custom-control-label" for="{{ $operator->id }}">{{ $operator->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button id="showMoreBtn" class="btn btn-primary btn-sm" type="button">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
                <button id="showLessBtn" class="btn btn-primary btn-sm" type="button" style="display: none;">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#showMoreBtn').on('click', function() {
                $('.custom-checkbox').show();
                $(this).hide();
                $('#showLessBtn').show();
            });

            $('#showLessBtn').on('click', function() {
                $('.custom-checkbox:gt(2)').hide();
                $(this).hide();
                $('#showMoreBtn').show();
            });
        });
    </script>


</div>
