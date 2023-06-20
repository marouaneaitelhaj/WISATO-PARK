@extends('layouts.app')
@section('title', ' - Create New Operator')
@section('content')
    <div class="container-fluid mb100">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Create Operator') }}
                        <a class="btn btn-sm btn-primary pull-right" href="{{ route('team.index') }}">User List</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('team.store2') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="image" class="col-md-3 col-form-label text-md-right">{{ __('Image') }}
                                    <span class="tcr text-danger">*</span></label>
                                <div class="col-md-9">

                                    <input id="image" type="file"
                                        class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">
                                    {{ __('Name') }}<span class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="name" type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ old('name') }}" autocomplete="off" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Phone"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Phone Number') }}<span
                                        class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="Phone" type="text" class="form-control" name="Phone">
                                </div>
                                @if ($errors->has('Phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('Phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="cin"
                                    class="col-md-3 col-form-label text-md-right">{{ __('cin') }}<span
                                        class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="cin" type="text" class="form-control" name="cin">
                                </div>
                                @if ($errors->has('cin'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cin') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-md-right">
                                    {{ __('E-Mail Address') }}<span class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                        value="{{ old('email') }}" autocomplete="off" required>

                                    <span class="form-text text-muted">
                                        This email will be used as your login email.
                                    </span>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role" class="col-md-3 col-form-label text-md-right">
                                    {{ __('Role') }}<span class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <select id="role" name="role"
                                        class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" required>
                                        <option value="2">Gardien</option>
                                        <option value="5">Caméra</option>
                                        <option value="3">agent</option>
                                    </select>

                                    <input type="hidden" name="required_role" value="true">

                                    @if ($errors->has('role'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="id_camera" class="col-md-3 col-form-label text-md-right">
                                    {{ __('id_camera') }}<span class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="id_camera" type="text"
                                        class="form-control{{ $errors->has('id_camera') ? ' is-invalid' : '' }}"
                                        name="id_camera" value="{{ old('id_camera') }}" autocomplete="off">

                                    @if ($errors->has('id_camera'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('id_camera') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="serial_number" class="col-md-3 col-form-label text-md-right">
                                    {{ __('serial_number') }}<span class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="serial_number" type="text"
                                        class="form-control{{ $errors->has('serial_number') ? ' is-invalid' : '' }}"
                                        name="serial_number" value="{{ old('serial_number') }}" autocomplete="off">

                                    @if ($errors->has('serial_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('serial_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-3 col-form-label text-md-right">
                                    {{ __('Password') }}<span class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>

                                    <input type="hidden" name="required_password" value="true">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Confirm Password') }}<span
                                        class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>
                            </div>



                            <div class="form-group row mb-0 d-flex justify-content-end">
                                <div class="col-md-7 offset-md-3 d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                        {{ __('Clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
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
