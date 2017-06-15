@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="container">
            
            <b>Passport Clients</b>
            <passport-clients></passport-clients>

            <b>Passport Authorized Clients</b>
            <passport-authorized-clients></passport-authorized-clients>

            <b>Passport Personal Access Tokens</b>
            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>

    </div>
</div>
@endsection

