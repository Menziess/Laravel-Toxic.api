@extends('layouts.app')

@section('content')

<!-- Manages Important Stuff -->
<Application
	:me="{{ Auth::check() ? Auth::user() : 'undefined' }}" 
	destination="{{ Session::has('destination') ? Session::get('destination') : 'undefined' }}"
></Application>

<!-- Beautifull Background -->
<Background></Background>

<!-- Navigation -->
<Navbar
	logout="{{ route('logout') }}"
	login="{{ route('login') }}"
></Navbar>

<!-- Content -->
<div class="container">
	<div class="row">

		<div class="container">

			<!-- Hidden Modal -->
			<PostNew></PostNew>

			<!-- Views -->
			<router-view></router-view>

		</div>

	</div>
</div>
@endsection
