@extends('layouts.app')
@section('title', ' - Parkzone List')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<div id="exampleModalLive" class="d-none modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" style="padding-right: 17px; display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Agents</h5>
                <button type="button" id="close" class="close btn" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="OperatorsList">

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('js/custom/settings/parkzone.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush