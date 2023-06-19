@extends('layouts.app')
@section('title', ' - Manage Team')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
<div class="main-panel">
    <div class="content-wrapper pb-0">
        <div class="container-fluid mb100">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Manage Team
                            <a class="btn btn-sm btn-primary pull-right" href="http://127.0.0.1:8000/team">User List</a>
                        </div>

                        <div class="card-body">
                            <form method="post" action="">
                                @csrf
                                <div class="form-group">
                                    <label for="parkzone">Select parkzone</label>
                                    <select name="parkzone" class="form-select" id="parkzone">
                                        @foreach ($parks as $park)
                                        <option value="{{$park->id}}">
                                            {{$park->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="operators">Select operators</label>
                                    <select name="operator[]" id="operators" multiple>
                                        @foreach ($agentOperatorList as $agentOperator)
                                        <option value="{{$agentOperator->operatorUser->id}}">
                                            {{$agentOperator->operatorUser->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mb100 my-5">
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
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/custom/settings/team.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script>
    new MultiSelectTag('operators'); // id
    // document.querySelectorAll('.input-container')[0].addEventListener('click', function() {
    //         document.querySelectorAll('.drawer')[0].classList.toggle('hidden');
    //     });
</script>
@endsection