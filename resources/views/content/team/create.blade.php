@extends('layouts.app')
@section('title', ' - Add Category')
@section('content')

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


                                <select name="countries" id="countries" multiple>
                                    @foreach ($operators as $operator)

                                    <option value="{{ $operator->id }}">{{ $operator->name }}</option>


                                    @endforeach

                                </select>
                            


                            </div>

                            

                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status" class="form-control">
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





    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('countries') // id

    </script>

@endsection