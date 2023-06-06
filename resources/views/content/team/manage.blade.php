@extends('layouts.app')
@section('title', ' - Manage Team')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
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
<ul>
    @foreach ($parks as $park)
    <li>{{$park->name}}</li>
    <li>
        <ul>
        @foreach ($park->operators as $operators)
        <li>{{$operators->name}}</li>
        @endforeach
        </ul>
    </li>
    @endforeach
</ul>

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script>
    new MultiSelectTag('operators'); // id
</script>
@endsection