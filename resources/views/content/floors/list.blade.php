@extends('layouts.app')
@section('title', ' - Floor List')
@section('content')
<div class="container-fluid mb100" bis_skin_checked="1">
    <div class="row justify-content-center" bis_skin_checked="1">
        <div class="col-md-12" bis_skin_checked="1">
            <div class="card" bis_skin_checked="1">
                <div class="card-header" bis_skin_checked="1">
                    Floor List
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('floors.create') }}">Create new</a>
                    new</a>
                </div>

                <div class="card-body" bis_skin_checked="1">
                    <div class="table-responsive" bis_skin_checked="1">
                        <div id="floorDatatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" bis_skin_checked="1"><div class="row" bis_skin_checked="1"><div class="col-12 col-sm-6" bis_skin_checked="1"><div class="dataTables_length" id="floorDatatable_length" bis_skin_checked="1"><label>Show <select name="floorDatatable_length" aria-controls="floorDatatable" class="form-control form-control-sm"><option value="10">10</option><option value="50">50</option><option value="100">100</option><option value="200">200</option><option value="-1">All</option></select> entries</label></div></div><div class="col-12 col-sm-6" bis_skin_checked="1"><div id="floorDatatable_filter" class="dataTables_filter" bis_skin_checked="1"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="floorDatatable"></label></div></div></div><div class="row" bis_skin_checked="1"><div class="col-12 col-sm-12" bis_skin_checked="1"><table id="floorDatatable" class="table table-borderd table-condenced w-100 dataTable no-footer" role="grid" aria-describedby="floorDatatable_info">

                        <thead>
                            <tr role="row">
                                <th class="no-sort sorting_asc" rowspan="1" colspan="1" style="width: 50px;" aria-label="id">id</th><th class="sorting" tabindex="0" aria-controls="floorDatatable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th><th class="sorting" tabindex="0" aria-controls="floorDatatable" rowspan="1" colspan="1" aria-label="Remarks: activate to sort column ascending">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($floors as $floor)
                            <tr>
                                <td>{{ $floor->id }}</td>
                                <td>{{ $floor->name }}</td>
                                <td>{{ $floor->remarks }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




