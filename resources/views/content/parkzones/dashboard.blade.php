@extends('layouts.app')
@section('title', ' - ParkZone Dashboard')
@section('content')
<div>
    <!-- <ul>
        @foreach($data as $dt)
        <li>
            {{ $dt }}
        </li>
        @endforeach
    </ul>
    <hr>
    <ul>
        @foreach($categories as $categorie)
        <li>
            {{ $categorie->type }}
        </li>
        @endforeach
    </ul> -->
    <div class="bg-white">
        <h2>
            ParkZone Dashboard:
        </h2>
        <div class="d-flex justify-content-start align-items-center">
            Quartier:
            <select class="form-select w-auto" style="border: none;">
                <option value="" selected hidden>{{$data->first()->name ?? ''}}</option>
                @foreach($data as $dt)
                <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@endsection