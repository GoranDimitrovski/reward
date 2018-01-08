@extends('layouts.master')

@section('content')
<h1>Employees</h1>
<div class="container">
    @foreach($employees as $employee)
    <div class="row">
        <div class="col-md-12 item">
            <h3 class="name">
                <img class="lazy-image" alt="{{ $employee->name }}" src="img/blank-avatar.png" data-src="{{ $employee->avatar }}" width="64" height="64">
                {{ $employee->name }}
            </h3>
            <p class="title">
                Title: {{ $employee->title }}
            </p>
            <p class="company">
                Company: {{ $employee->company->name }}
            </p>
            <p class="bio">
                Bio: {!! $employee->bio !!}
            </p>
        </div>
    </div>
    @endforeach
    <div class="text-center">
        {{ $employees->links() }}
    </div>

</div>

@stop