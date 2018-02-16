@extends('admin.layouts.auth')

@section('content')
<div class="flex login-screen pa-sm align-items-m">
    <div class="panel panel-body ma-auto pa-lg" style="width: 100%; max-width: 464px; max-height: 464px;">
        <div class="text-center mb-md">
            <img src="https://grazecart.com/images/graze-cart-logo.svg" width="200">
        </div>    
        <div class="text-center fs-2 bold mb-md text-gray-dark">
            Administration
        </div>
        @if(Session::has('flash_notification.message'))
            <div class="text-danger text-center mb-md">{!! Session::get('flash_notification.message') !!}</div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control input-fat" placeholder="email"/>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" value="{{ old('password') }}" class="form-control input-fat" placeholder="password"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-action btn-block input-fat">Sign In <i class="fa fa-chevron-right"></i> </button>
            </div>
        </form>
        <div class="text-center">
            <a href="{{ route('password.request') }}" class="fs-sm text-gray-medium">Forgot password?</a>
        </div>    
    </div>
</div>
@endsection
