@extends('layouts.app')
@section('title', ' - Add Category')
@section('content')

    @if (session()->has('flash_message'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: '{{ session('flash_message.type') }}',
                text: '{{ session('flash_message.message') }}'
            });
        </script>
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        {{ __('Add Team') }}
                        <a class="btn btn-sm btn-primary pull-right" href="">Team List</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('team.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="agent">Agent</label>
                                <input type="text" name="agent_id" id="agent_id" class="form-control"
                                    value="{{ auth()->user()->name }}" readonly>
                                <input type="hidden" name="agent" value="{{ auth()->user()->id }}">
                            </div>

                            <div class="form-group">
                                <label for="operator">Operator</label>

                                <select name="operator[]" id="operator" multiple>
                                    @foreach ($operators as $operator)
                                        <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="status" id="status" class="form-control">
                                    <option value="In the team">In the team</option>
                                    <option value="Outside the team">Outside the team</option>
                                    <option value="Departed">Departed</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" id="remark" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Team</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row justify-content-center mt-3" bis_skin_checked="1">
        <div class="col-md-12" bis_skin_checked="1">
            <div class="card" bis_skin_checked="1">
                <div class="card-header" bis_skin_checked="1">
                    All Team
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
                                        <label>Search:<input type="search" class="form-control form-control-sm" id="categorySearchInput" placeholder="" aria-controls="categoryDatatable">
                                        </label>
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
                                                    style="width: 50px;" aria-label="#SL">#SL</th>
                                                <th class="sorting" tabindex="0" aria-controls="categoryDatatable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Type: activate to sort column ascending">Team Leader</th>
                                                <th class="sorting" tabindex="0" aria-controls="categoryDatatable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Description: activate to sort column ascending">Operators
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="categoryDatatable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Type: activate to sort column ascending">Phone
                                                </th>
                                                <th lclass="sorting" tabindex="0" aria-controls="categoryDatatable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Type: activate to sort column ascending">Email
                                                </th>
                                                <th lclass="sorting" tabindex="0" aria-controls="categoryDatatable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Type: activate to sort column ascending">CIN
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($agentOperatorList as $index => $agentOperator)
                                            @foreach ($agentOperator['operators'] as $operator)

                                            <tr role="row" class="odd">
                                                <td class="no-sort sorting_1">1</td>
                                                <td>{{ $agentOperator['agent'] }}</td>
                                                <td>
                                                    {{ $operator['name'] }}
                                                <td>
                                                    {{ $operator['Phone'] }}
                                                </td>
                                                <td>
                                                    {{ $operator['email'] }}
                                                </td>
                                                <td>
                                                    {{ $operator['cin'] }}
                                                </td>
                                                <td class=" text-end width-5-per"><a
                                                        href="http://127.0.0.1:8000/category/8/edit"><i
                                                            class="fa fa-pencil-square-o text-info" aria-hidden="true"
                                                            title="Edit Category"></i></a>| <button
                                                        class="btn btn-link p-0"
                                                        onclick="deleteData('http://127.0.0.1:8000/category/8', '#categoryDatatable')"><i
                                                            class="fs-6 fa fa-trash-o text-danger" aria-hidden="true"
                                                            title="Delete Category"></i></button></td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-sm-6" bis_skin_checked="1">
                                    <div class="dataTables_info" id="categoryDatatable_info" role="status"
                                        aria-live="polite" bis_skin_checked="1">Showing 1 to 8 of 8 entries</div>
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







    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('operator') 

    document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.getElementById("categorySearchInput");

        searchInput.addEventListener("input", function() {
            var searchValue = searchInput.value.toLowerCase();

            var tableBody = document.querySelector("#categoryDatatable tbody");

            var rows = tableBody.querySelectorAll("tr");

            rows.forEach(function(row) {
                var operatorsCell = row.querySelector("td:nth-child(3)");

                var operatorNames = operatorsCell.textContent.trim().toLowerCase();

                var operatorNamesArray = operatorNames.split("\n");

                var isMatch = operatorNamesArray.some(function(operatorName) {
                    return operatorName.includes(searchValue);
                });

                if (isMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
    </script>

@endsection
