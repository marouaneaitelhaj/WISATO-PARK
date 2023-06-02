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
                            <input type="text" name="agent_id" id="agent_id" class="form-control" value="{{ auth()->user()->name }}" readonly>
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




<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Your Team
                <a class="btn btn-sm btn-primary pull-right" href="http://127.0.0.1:8000/category/create"> Create new</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed w-100 dataTable no-footer" id="categoryDatatable" role="grid" aria-describedby="categoryDatatable_info">
                        <thead>
                            <tr role="row">
                                {{-- <th class="no-sort sorting_asc" rowspan="1" colspan="1" style="width: 50px;" aria-label="#SL"></th> --}}
                                <th>Team Leader</th>
                                <th>Operators</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>CIN</th> <!-- Added column for CIN -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agentOperatorList as $index => $agentOperator)
                            <tr role="row" class="odd">
                                {{-- <td class="no-sort sorting_1">{{ $index + 1 }}</td> --}}
                                <td>{{ $agentOperator['agent'] }}</td>
                                <td>
                                    <ul>
                                        @foreach($agentOperator['operators'] as $operator)
                                        <li>{{ $operator['name'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($agentOperator['operators'] as $operator)
                                        <li>{{ $operator['Phone'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($agentOperator['operators'] as $operator)
                                        <li>{{ $operator['email'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($agentOperator['operators'] as $operator)
                                        <li>{{ $operator['cin'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script>
    new MultiSelectTag('operator') // id
</script>

@endsection
