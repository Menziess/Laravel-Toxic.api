@extends('layouts.app')

@section('content')

@include('layouts.nav')

<div class="container">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <br><div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <span id="email-addon" class="input-group-addon">Email</span>                     
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" 
                                aria-descibedby="email-addon" required>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                        <br><div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <span id="password-addon" class="input-group-addon">Password</span>
                            <input id="password" type="password" class="form-control" name="password" 
                                aria-describedby="password-addon" required>
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                        <br><div class="input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <span id="password-confirm-addon" class="input-group-addon">Password</span>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" 
                                aria-describedby="password-confirm-addon" required>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif

                        <br><div class="input-group">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
