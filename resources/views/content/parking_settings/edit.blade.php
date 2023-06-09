@extends('layouts.app')
@section('title', ' - Edit Parking Slot')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit Parking Slot') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.index') }}">Parking Slot
                        List</a>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ route('parking_settings.update',['parking_setting' => $parking_setting->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="text-md-right">{{ __('Category') }} <span
                                            class="tcr text-danger">*</span></label>
                                    <select name="category_id" required id="category_id"
                                        class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $parking_setting->
                                            category_id) == $category->id ) ? ' selected' : '' }}>{{
                                            $category->type }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parkzone_id" class="text-md-right">{{ __('Parkzone') }} <span
                                            class="tcr text-danger">*</span></label>
                                    <select name="parkzone_id" id="parkzone_id" required
                                        class="form-control{{ $errors->has('parkzone_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($parkzones as $parkzone)
                                        <option value="{{ $parkzone->id }}" {{ (old('parkzone_id', $parking_setting->parkzone_id)
                                            == $parkzone->id ) ? ' selected' : '' }}>{{ $parkzone->name
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="text-md-right">{{ __('Slot Name') }} <span
                                            class="tcr text-danger">*</span></label>
                                    <input type="text" required
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        value="{{ old('name', $parking_setting->name ) }}" name="name">
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="identity" class="text-md-right">{{ __('Identity') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('identity') ? ' is-invalid' : '' }}"
                                        value="{{ old('identity', $parking_setting->identity) }}" name="identity">
                                    @if ($errors->has('identity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('identity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks" class="text-md-right">{{ __('Remarks') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}"
                                        value="{{ old('remarks', $parking_setting->remarks) }}" name="remarks">
                                    @if ($errors->has('remarks'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('remarks') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <div class="pull-right d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                        {{ __('Clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
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
@endsection