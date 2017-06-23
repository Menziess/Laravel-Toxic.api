@extends('layouts.app')

@section('content')
@include('layouts.nav')

<div class="container">
    <div class="row">

        <div class="container">
            
            <!-- Hidden Modal -->
            <NewPost></NewPost>

            <!-- Post Manager -->
            <Manager json="{{ $posts }}"></Manager>

        </div>

    </div>
</div>
@endsection
