@extends('layouts.app')
@section('title', ' - Create New Parking Slot')
@section('content')
@livewireStyles
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Create Parking Slot') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.index') }}">Parking Slot List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('parking_settings.store') }}">
                        @csrf

                        <div class="column">
                            <div class="">
                                <div class="form-group">
                                    <label for="category_id" class="text-md-right">{{ __('Category') }} <span class="tcr text-danger">*</span></label>
                                    <div class="d-flex justify-content-around">
                                        @foreach ($categories as $category)
                                        <div class="d-flex border align-items-end">
                                            <input class="form-check-input" type="checkbox" name="category_id[]" value="{{$category->id}}" id="category_id">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $category->type }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-100">
                                <div class="form-group">
                                    <label for="parkzone_id" class="text-md-right">{{ __('ParkZone') }} <span class="tcr text-danger">*</span></label>
                                    <select name="parkzone_id" id="parkzone_id" required class="form-control{{ $errors->has('parkzone_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($parkzones as $parkzone)
                                        <option value="{{ $parkzone->id }}" {{ (old('parkzone_id') == $parkzone->id ) ? ' selected' : '' }}>{{ $parkzone->name
                                            }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('parkzone_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('parkzone_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="W-100">
                                <div class="form-group">
                                    <label for="slot_name" class="text-md-right">{{ __('Slot Name') }} <span class="tcr text-danger">*</span></label>
                                    <input type="text" required class="form-control{{ $errors->has('slot_name') ? ' is-invalid' : '' }}" value="{{ old('slot_name') }}" name="slot_name">
                                    @if ($errors->has('slot_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('slot_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-100">
                                <div class="form-group">
                                    <label for="identity" class="text-md-right">{{ __('Identity') }}</label>
                                    <input type="text" class="form-control{{ $errors->has('identity') ? ' is-invalid' : '' }}" value="{{ old('identity') }}" name="identity">
                                    @if ($errors->has('identity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('identity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 w-100">
                                @livewire('search-operator')
                            </div>
                            <!-- <p>heloo</p> -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks" class="text-md-right">{{ __('Remarks') }}</label>
                                    <input type="text" class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}" value="{{ old('remarks') }}" name="remarks">
                                    @if ($errors->has('remarks'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('remarks') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @if ($errors->has('lng'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lng') }}</strong>
                            </span>
                            @endif
                            @if ($errors->has('lat'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lat') }}</strong>
                            </span>
                            @endif
                            <div class="col-12">
                                <div class="pull-right d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                        {{ __('Clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@livewireScripts
@endsection