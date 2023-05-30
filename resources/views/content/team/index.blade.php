@extends('layouts.app')
@section('title', ' - Team List')
@section('content')


    <div class="row justify-content-center" bis_skin_checked="1">
        <div class="col-md-12" bis_skin_checked="1">
            <div class="card" bis_skin_checked="1">
                <div class="card-header" bis_skin_checked="1">
                    Your Team
                    <a class="btn btn-sm btn-primary pull-right" href="http://127.0.0.1:8000/category/create"> Create new</a>
                </div>

                <div class="card-body" bis_skin_checked="1">
                    <div class="table-responsive" bis_skin_checked="1">

                        <div id="categoryDatatable_wrapper"
                            class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" bis_skin_checked="1">
                            <div class="row" bis_skin_checked="1">
                                <div class="col-12 col-sm-6" bis_skin_checked="1">
                                    <div class="dataTables_length" id="categoryDatatable_length" bis_skin_checked="1">
                                        <label>Show <select name="categoryDatatable_length"
                                                aria-controls="categoryDatatable" class="form-control form-control-sm">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6" bis_skin_checked="1">
                                    <div id="categoryDatatable_filter" class="dataTables_filter" bis_skin_checked="1">
                                        <label>Search:<input type="search" class="form-control form-control-sm"
                                                placeholder="" aria-controls="categoryDatatable"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" bis_skin_checked="1">
                                <div class="col-12 col-sm-12" bis_skin_checked="1">
                                    <table class="table table-borderd table-condenced w-100 dataTable no-footer"
                                        id="categoryDatatable" role="grid" aria-describedby="categoryDatatable_info">

                                        <thead>
                                            <tr role="row">
                                                <th class="no-sort sorting_asc" rowspan="1" colspan="1"
                                                    style="width: 50px;" aria-label="#SL">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr role="row" class="odd">
                                                <td class="no-sort sorting_1">9</td>
                                                <td>Gasoline Truck</td>
                                                <td>Gasoline Truck Description</td>
                                                <td>Enable</td>
                                                <td class=" text-end width-5-per">
                                                    <a href="http://127.0.0.1:8000/category/9/edit">
                                                        <i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Category"></i>
                                                    </a>|
                                                    <button class="btn btn-link p-0" onclick="deleteData('http://127.0.0.1:8000/category/9', '#categoryDatatable')">
                                                        <i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Category"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-sm-6" bis_skin_checked="1">
                                    <div class="dataTables_info" id="categoryDatatable_info" role="status"
                                        aria-live="polite" bis_skin_checked="1">Showing 1 to 9 of 9 entries</div>
                                </div>
                                <div class="col-12 col-sm-6" bis_skin_checked="1">
                                    <div class="dataTables_paginate paging_simple_numbers" id="categoryDatatable_paginate"
                                        bis_skin_checked="1">
                                        <ul class="pagination">
                                            <li class="paginate_button page-item previous disabled"
                                                id="categoryDatatable_previous"><a href="#"
                                                    aria-controls="categoryDatatable" data-dt-idx="0" tabindex="0"
                                                    class="page-link">←</a></li>
                                            <li class="paginate_button page-item active"><a href="#"
                                                    aria-controls="categoryDatatable" data-dt-idx="1" tabindex="0"
                                                    class="page-link">1</a></li>
                                            <li class="paginate_button page-item next disabled"
                                                id="categoryDatatable_next"><a href="#"
                                                    aria-controls="categoryDatatable" data-dt-idx="2" tabindex="0"
                                                    class="page-link">→</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
