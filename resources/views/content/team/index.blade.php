@extends('layouts.app')
@section('title', ' - Team List')
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


<div class="row justify-content-center">
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

@endsection
