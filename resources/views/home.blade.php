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

        <p>
            Due to decisions made by simracing.gp that are beyond our control, we've been forced
            to indefinitely suspend development and disabled the tools here.
        </p>
        <p>
            Previous abilities such as automated event registrations, automatic driver split calculations,
            incident reporting/penalties, and standings tracking will no longer work.
        </p>
        <p>
            The current state of this site will remain as it is for now as a way to keep an archive of
            previous events that were tracked through here.
        </p>
            <br>
        <p>
            Anyone with an existing account will still be able to log in. However, new registrations will not
            go through.
        </p>

    </div>
</div>

@endsection
