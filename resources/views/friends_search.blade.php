@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div>
        <h1><i>Search Friends</i></h1>
        <input class="typeahead form-control" type="text">
    </div>
 
</div>


@endsection
