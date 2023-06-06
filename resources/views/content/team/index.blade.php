@extends('layouts.app')
@section('title', ' - Team List')
@section('content')




<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Team List') }}
                    <a class="btn btn-sm btn-info pull-right" href="{{ route('team.create') }}">Create
                        new</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="teamDataTable" class="table table-borderd table-condenced w-100">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="{{ asset('js/custom/settings/team.js') }}"></script>
@endpush