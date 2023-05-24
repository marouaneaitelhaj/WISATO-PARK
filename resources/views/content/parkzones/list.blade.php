@extends('layouts.app')
@section('title', ' - Parkzone List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Parkzone List') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parkzones.create') }}">Create
                        new</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="parkzoneDatatable" class="table table-borderd table-condenced w-100">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/custom/settings/parkzone.js') }}"></script>
@endpush