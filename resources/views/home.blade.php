@extends('layout.layout')

@section('title', 'Home')

@section('content')

<div class="row">
    <div class="col-sm-12">


        @if(Auth::check())
            <h4 class="card-title">Welcome {{ Auth::user()->name }}</h4>
        @else
            <h4 class="card-title">Welcome</h4>
        @endif

        Login with discord should be working.

    </div>
</div>

@endsection
