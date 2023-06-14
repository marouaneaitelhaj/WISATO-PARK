{{-- @extends('layouts.app')
@section('title', ' - Edit Tariff')
@section('content')
<link rel="stylesheet" href="{{ asset('css/custom/tariff.css') }}" />
<div class="container-fluid mb100">   
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card  mb-5">
                <div class="card-header">
                    {{ __('Edit Tariff') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('tariff.index') }}">Tariff List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tariff.update', ['tariff' => $tariff->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"> {{ __('Name') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name')??$tariff->name }}" autocomplete="off" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="start_date"  type="text" class="form-control dateTimePicker{{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" value="{{ old('start_date')??$tariff->start_date }}" autocomplete="off" required>

                                @if ($errors->has('start_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right"> {{ __('End Date') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="end_date"  type="text" class="form-control dateTimePicker{{ $errors->has('end_date') ? ' is-invalid' : '' }}" name="end_date" value="{{ old('end_date')??$tariff->end_date }}" autocomplete="off" required>

                                @if ($errors->has('end_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Type') }} <span class="tcr i-req">*</span> </label>
                            <div class="col-md-8">
                                <select name="category_id" id="category_id" class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" required>                                    
                                    <?php
                                    // foreach ($categories as $key => $value) {
                                    //     echo '<option value="'.$value->id.'" '.(($value->id == $tariff->category_id) ? ' selected' : '').'>'.$value->type.'</option>';
                                    // }
                                    ?>
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="min_amount" class="col-md-4 col-form-label text-md-right"> {{ __('Min Amount') }}<span class="tcr i-req">*</span> </label>

                            <div class="col-md-8">
                                <input id="min_amount" type="number" step="any" class="form-control {{ $errors->has('min_amount') ? ' is-invalid' : '' }}" name="min_amount" value="{{ old('min_amount')??$tariff->min_amount }}" autocomplete="off" required>

                                @if ($errors->has('min_amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('min_amount') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}<span class="tcr i-req">*</span>  <i class="f-12"> (Per/hour)</i></label>

                            <div class="col-md-8">
                                <input id="amount" type="number" step="any" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount')??$tariff->amount }}" autocomplete="off" required>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right"> {{ __('Status') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-8">

                                <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                                    <option value="1" {{ ($tariff->status == '1') ? ' selected' : '' }}>Enable</option>
                                    <option value="0" {{ ($tariff->status == '0') ? ' selected' : '' }}>Disable</option>
                                </select>

                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0 d-flex justify-content-end">
                            <div class="col-md-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">
                                    {{ __('Update') }}
                                </button>
                                <button type="reset" class="btn btn-secondary" id="frmClear">
                                    {{ __('Clear') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection --}}




@extends('layouts.app')
@section('title', ' - Edit Tariff')
@section('content')
<link rel="stylesheet" href="{{ asset('css/custom/tariff.css') }}" />

<div class="container-fluid mb100">   
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card  mb-5">
                <div class="card-header">
                    {{ __('Edit Tariff') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('tariff.index') }}">Tariff List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tariff.update', ['tariff' => $tariff->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"> {{ __('Name') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name')??$tariff->name }}" autocomplete="off" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="start_date"  type="text" class="form-control dateTimePicker{{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" value="{{ old('start_date')??$tariff->start_date }}" autocomplete="off" required>

                                @if ($errors->has('start_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right"> {{ __('End Date') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="end_date"  type="text" class="form-control dateTimePicker{{ $errors->has('end_date') ? ' is-invalid' : '' }}" name="end_date" value="{{ old('end_date')??$tariff->end_date }}" autocomplete="off" required>

                                @if ($errors->has('end_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Type') }} <span class="tcr i-req">*</span> </label>
                            <div class="col-md-8">
                                <select name="category_id" id="category_id" class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" required>                                    
                                    <?php
                                    foreach ($categories as $key => $value) {
                                        echo '<option value="'.$value->id.'" '.(($value->id == $tariff->category_id) ? ' selected' : '').'>'.$value->type.'</option>';
                                    }
                                    ?>
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}<span class="tcr i-req">*</span>  <i class="f-12"> (Per/hour)</i></label>

                            <div class="col-md-8">
                                <input id="amount" type="number" step="any" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount')??$tariff->amount }}" autocomplete="off" required>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right"> {{ __('Status') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-8">

                                <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                                    <option value="1" {{ ($tariff->status == '1') ? ' selected' : '' }}>Enable</option>
                                    <option value="0" {{ ($tariff->status == '0') ? ' selected' : '' }}>Disable</option>
                                </select>

                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row">
                        <label for="validate_start_date" class="col-md-4 col-form-label text-md-right">{{ __('Validate Start Date') }} <span class="tcr i-req">*</span></label>
                            <div class="col-md-8">
                                <input id="validate_start_date"  type="text" class="form-control dateTimePicker{{ $errors->has('validate_start_date') ? ' is-invalid' : '' }}" name="validate_start_date" value="{{ old('validate_start_date')??$tariff->validate_start_date }}" autocomplete="off" required>

                                @if ($errors->has('validate_start_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validate_start_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group row">
                        <label for="validate_end_date" class="col-md-4 col-form-label text-md-right">{{ __('Validate End Date') }} <span class="tcr i-req">*</span></label>
                            <div class="col-md-8">
                                <input id="validate_end_date"  type="text" class="form-control dateTimePicker{{ $errors->has('validate_end_date') ? ' is-invalid' : '' }}" name="validate_end_date" value="{{ old('validate_end_date')??$tariff->validate_end_date }}" autocomplete="off" required>

                                @if ($errors->has('validate_end_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validate_end_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group row">
                        <label for="day" class="col-md-4 col-form-label text-md-right">{{ __('Day') }} <span class="tcr i-req">*</span></label>
                            <div class="col-md-8">
                                <input id="day"  type="text" class="form-control dateTimePicker{{ $errors->has('day') ? ' is-invalid' : '' }}" name="day" value="{{ old('day')??$tariff->day }}" autocomplete="off" required>
                                

                                @if ($errors->has('day'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('day') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shadow_amount" class="col-md-4 col-form-label text-md-right">{{ __('Shadow Amount') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-8">
                                <input id="shadow_amount" type="text" class="form-control{{ $errors->has('shadow_amount') ? ' is-invalid' : '' }}" name="shadow_amount" value="{{ old('shadow_amount')??$tariff->shadow_amount }}" required>

                                @if ($errors->has('shadow_amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('shadow_amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="number_hour" class="col-md-4 col-form-label text-md-right">{{ __('Number Hour') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-8">
                                <input id="number_hour" type="text" class="form-control{{ $errors->has('number_hour') ? ' is-invalid' : '' }}" name="number_hour" value="{{ old('number_hour')??$tariff->number_hour }}" required>

                                @if ($errors->has('number_hour'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('number_hour') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_amount" class="col-md-4 col-form-label text-md-right">{{ __('Total Amount') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-8">
                                <input id="total_amount" type="text" class="form-control{{ $errors->has('total_amount') ? ' is-invalid' : '' }}" name="total_amount" value="{{ old('total_amount')??$tariff->total_amount }}" required>

                                @if ($errors->has('total_amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('total_amount') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>






                        <div class="form-group row mb-0 d-flex justify-content-end">
                            <div class="col-md-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">
                                    {{ __('Update') }}
                                </button>
                                <button type="reset" class="btn btn-secondary" id="frmClear">
                                    {{ __('Clear') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection