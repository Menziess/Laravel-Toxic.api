@extends('layouts.app')

@section('content')

<Background></Background>

<Navbar
	destination="{{ Session::has('destination') ? Session::get('destination') : '' }}"
	:currentuser="{{ Auth::guest() ?: Auth::user() }}" 
	logout="{{ route('logout') }}"
	login="{{ route('login') }}"
	></Navbar>

<div class="container">
	<div class="row">

		<div class="container">

			<!-- Hidden Modal -->
			<NewPost></NewPost>

			<!-- Views -->
			<router-view></router-view>

		</div>

	</div>
</div>
@endsection
