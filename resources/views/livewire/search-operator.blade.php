<div class="form-group">
    <label for="category_id" class="text-md-right">{{ __('Operators') }} <span class="tcr text-danger">*</span></label>

    <div class="border form-group">
        <div class="d-flex flex-wrap border w-100 justify-content-between align-items-center">
            <ul class="d-flex flex-wrap list-unstyled m-0">
                @foreach ($selectedOperators as $index => $operator)
                <li style="background-color: #2dce89;" class="px-2 m-1 py-1 rounded d-flex">
                    <div>
                        {{$operator['name']}}
                    </div>
                    <div wire:click="delete({{$index}})" class="align-items-start" style="display: flex;">
                        <i class="fa fa-times  text-white" aria-hidden="true"></i>
                    </div>
                    <input type="text" hidden value="{{$operator['id']}}" name="operator[]">
                </li>
                @endforeach
                <input type="text" style="border: none;" wire:model="search" class="flex-grow-1">

            </ul>
        </div>
        <div class="border">
            @foreach ($operators as $index => $operator)
            <div wire:click="add({{$operator}})" style="cursor: pointer;" class="border tags d-flex align-items-center">
                <span>
                    {{$operator->name}}
                </span>
            </div>
            @endforeach
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