@extends('layout.layout')

@section('content')
<section class="sign-in-page">
    <div class="container p-0">
        <div class="row no-gutters">
            <div class="col-sm-12 align-self-center">
                <div class="sign-in-from bg-white">
                    <h1 class="mb-0">Sign in</h1>
                    <p>Enter your email address and password to access admin panel.</p>
                    <form class="mt-4" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control mb-0" id="email" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <a href="#" class="float-right">Forgot password?</a>
                            <input type="password" class="form-control mb-0" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Sign in</button>
                        </div>
                        <div class="sign-info">
                            @foreach($errors->all() as $message)
                            {{ $message }} <br>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
