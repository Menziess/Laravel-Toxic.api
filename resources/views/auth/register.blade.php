@extends('layouts.static')

@section('head')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
@endsection

@section('content')

<div class="container">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="input-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <span id="first_name-addon" class="input-group-addon">First name</span>
                            <input id="first_name" type="text" class="form-control" name="first_name" 
                                value="{{ old('first_name') }}" aria-describedby="first_name-addon" required autofocus>
                        </div>
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif

                        <br><div class="input-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <span id="last_name-addon" class="input-group-addon">Last name</span>
                            <input id="last_name" type="text" class="form-control" name="last_name" 
                                value="{{ old('last_name') }}" aria-describedby="last_name-addon" required>
                        </div>
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif

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

                        <br><div class="input-group">
                            <span id="password-confirm-addon" class="input-group-addon">Password</span>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" 
                                aria-describedby="password-confirm-addon" required>
                        </div>
                        @if ($errors->has('password-confirm'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password-confirm') }}</strong>
                            </span>
                        @endif

                        <br><div class="g-recaptcha" data-sitekey="6Lcd8ykUAAAAAJuxUhuwGlgDcZgw2vDuWXSaV_wB"
                            style="transform:scale(0.85);-webkit-transform:scale(0.85);transform-origin:0 0;-webkit-transform-origin:0 0;"
                            ></div>
                        @if ($errors->has('recaptcha'))
                            <span class="help-block">
                                <strong>{{ $errors->first('recaptcha') }}</strong>
                            </span>
                        @endif

                        <br><div class="input-group">
                            <button
                                type="submit"
                                class="btn btn-primary">
                                Register
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
