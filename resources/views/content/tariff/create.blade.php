@extends('layouts.app')
@section('title', ' - Add Tariff')
@section('content')
@livewireStyles

<link rel="stylesheet" href="{{ asset('css/custom/tariff.css') }}" />
<div class="container-fluid mb100">
   
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    {{ __('Add Tariff') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('tariff.index') }}">Tariff List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tariff.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"> {{ __('Name') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autocomplete="off" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        @livewire('tariff')

 

                        
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right"> {{ __('Type') }} <span class="tcr i-req">*</span></label>
                            <div class="col-md-8">
                                <select name="category_id" id="category_id" class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" required>
                                    <?php
                                    foreach ($categories as $key => $value) {
                                        echo '<option value="'.$value->id.'">'.$value->type.'</option>';
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
{{-- 
                        <div class="form-group row">
                            <label for="day" class="col-md-4 col-form-label text-md-right"> {{ __('Day') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8 d-flex">
                                <div class=""><input id="day" type="radio" name="day" value="morning"> Morning <span class="tcr i-req">*</span></div>
                                <div class="mx-5"><input id="day" type="radio" name="day" value="evening"> Evening <span class="tcr i-req">*</span></div>
                            </div>
                        </div> --}}







                        {{-- <div class="d-flex flex-row">
                            <div class="form-group w-100 d-flex align-items-center">
                                <label class="col-md-6 col-form-label text-md-right" for="start_date">{{ __('Start Date') }}<span class="tcr i-req">*</span></label>
                                <input id="start_date" type="text" class="mx-2 form-control dateTimePicker{{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" value="{{ old('start_date') }}" autocomplete="off" required>
                                @if ($errors->has('start_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <div class="form-group w-50 d-flex align-items-center">
                                <label class="mx-2" for="end_date">{{ __('End Date') }}<span class="tcr i-req">*</span></label>
                                <input id="end_date" type="text" class="form-control dateTimePicker{{ $errors->has('end_date') ? ' is-invalid' : '' }}" name="end_date" value="{{ old('end_date') }}" autocomplete="off" required>
                                @if ($errors->has('end_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}
                        
                        


                        

                        <div class="form-group row">
                            <label for="day" class="col-md-4 col-form-label text-md-right"> {{ __('Day') }} <span class="tcr i-req">*</span></label>
                            <div class="col-md-8 d-flex">
                              <div class=""><input id="morning" type="radio" name="day" value="morning"> Morning <span class="tcr i-req">*</span></div>
                              <div class="mx-5"><input id="evening" type="radio" name="day" value="evening"> Evening <span class="tcr i-req">*</span></div>
                            </div>
                          </div>
                          
                          <div class="d-flex flex-row">
                            <div class="form-group w-100 d-flex align-items-center">
                              <label class="col-md-6 col-form-label text-md-right" for="start_date">{{ __('Start Date') }}<span class="tcr i-req">*</span></label>
                              <input id="start_date" type="datetime-local" class="mx-2 form-control datePicker{{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" value="{{ old('start_date') }}" autocomplete="off" required>
                              @if ($errors->has('start_date'))
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('start_date') }}</strong>
                              </span>
                              @endif
                            </div>
                          
                            <div class="form-group w-50 d-flex align-items-center">
                              <label class="mx-2" for="end_date">{{ __('End Date') }}<span class="tcr i-req">*</span></label>
                              <input id="end_date" type="datetime-local" class="form-control datePicker{{ $errors->has('end_date') ? ' is-invalid' : '' }}" name="end_date" value="{{ old('end_date') }}" autocomplete="off" required>
                              @if ($errors->has('end_date'))
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('end_date') }}</strong>
                              </span>
                              @endif
                            </div>
                          </div>
                          


                          <script>
                            const morningRadio = document.getElementById('morning');
                            const eveningRadio = document.getElementById('evening');
                            const startDateInput = document.getElementById('start_date');
                            const endDateInput = document.getElementById('end_date');
                          
                            morningRadio.addEventListener('change', function() {
                              if (morningRadio.checked) {
                                const currentDate = new Date();
                                currentDate.setHours(8, 0);
                                startDateInput.value = getFormattedDate(currentDate);
                          
                                const endDate = new Date(currentDate);
                                endDate.setHours(18, 0);
                                endDateInput.value = getFormattedDate(endDate);
                              }
                            });
                          
                            eveningRadio.addEventListener('change', function() {
                              if (eveningRadio.checked) {
                                const currentDate = new Date();
                                currentDate.setHours(18, 0);
                                startDateInput.value = getFormattedDate(currentDate);
                          
                                const endDate = new Date(currentDate);
                                endDate.setDate(endDate.getDate() + 1);
                                endDate.setHours(2, 0);
                                endDateInput.value = getFormattedDate(endDate);
                              }
                            });
                          
                            function getFormattedDate(date) {
                              const year = date.getFullYear();
                              const month = (date.getMonth() + 1).toString().padStart(2, '0');
                              const day = date.getDate().toString().padStart(2, '0');
                              const hours = date.getHours().toString().padStart(2, '0');
                              const minutes = date.getMinutes().toString().padStart(2, '0');
                          
                              return `${year}-${month}-${day}T${hours}:${minutes}`;
                            }
                          </script>
                          
                          
                        


                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}<span class="tcr i-req">*</span>  <i class="f-12"> (Per/hour)</i></label>

                            <div class="col-md-8">
                                <input id="amount" type="number" step="any" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" autocomplete="off" required>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>


                        <div class="form-group row">
                            <label for="shadow_amount" class="col-md-4 col-form-label text-md-right"> {{ __('Shadow Amount') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="Shadow_amount" type="number" step="any" class="form-control {{ $errors->has('shadow_amount') ? ' is-invalid' : '' }}" name="shadow_amount" value="{{ old('shadow_amount') }}" autocomplete="off" required>

                                @if ($errors->has('shadow_amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('shadow_amount') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>

                        <div class="form-group row">
                            <label for="24h_amount" class="col-md-4 col-form-label text-md-right"> {{ __('Total Amount for 24h') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-8">
                                <input id="24h_amount" type="number" step="any" class="form-control {{ $errors->has('24h_amount') ? ' is-invalid' : '' }}" name="24h_amount" value="{{ old('24h_amount') }}" autocomplete="off">

                                @if ($errors->has('24h_amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('24h_amount') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
 
                        <div class="d-flex flex-row">
                            <div class="form-group w-100 d-flex align-items-center">
                                <label class="col-md-6 col-form-label text-md-right" for="validate_start_date">{{ __('Validate Start Date') }}<span class="tcr i-req">*</span></label>
                                <input id="validate_start_date" type="text" class="mx-2 form-control dateTimePicker{{ $errors->has('validate_start_date') ? ' is-invalid' : '' }}" name="validate_start_date" value="{{ old('validate_start_date') }}" autocomplete="off" required>
                                @if ($errors->has('validate_start_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validate_start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <div class="form-group w-50 d-flex align-items-center">
                                <label class="mx-2" for="validate_end_date">{{ __('Validate End Date') }}<span class="tcr i-req">*</span></label>
                                <input id="validate_end_date" type="text" class="form-control dateTimePicker{{ $errors->has('validate_end_date') ? ' is-invalid' : '' }}" name="validate_end_date" value="{{ old('validate_end_date') }}" autocomplete="off" required>
                                @if ($errors->has('validate_end_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validate_end_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}<span class="tcr i-req">*</span> </label>
                            <div class="col-md-8">

                                <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                                    <option value="1" {{ (old('status') == '1') ? ' selected' : '' }}>Enable</option>
                                    <option value="0" {{ (old('status') == '0') ? ' selected' : '' }}>Disable</option>
                                </select>

                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>                                            

                        <div class="form-group row mb-0 d-flex justify-content-end">
                            <div class="col-md-4 offset-md-2 justify-content-end d-flex">
                                <button type="submit" class="btn btn-success me-2">
                                    {{ __('Save') }}
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
@livewireScripts

@endsection