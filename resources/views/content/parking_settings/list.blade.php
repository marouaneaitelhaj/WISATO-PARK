@extends('layouts.app')
@section('title', ' - Parking Slot List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Parking Slot List') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.create') }}">Create new</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="parkingSlotDatatable" class="table table-borderd table-condenced w-100">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="exampleModalLive"  class="d-none modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" style="padding-right: 17px; display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Operators</h5>
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
<script src="{{ asset('js/custom/settings/parking_setting.js') }}"></script>
@endpush