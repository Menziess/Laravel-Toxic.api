@extends('layouts.app')

@section('content')

<!-- Manages Important Stuff -->
<Application
	logout="{{ route('logout') }}"
	login="{{ route('login') }}"
	destination="{{ Session::has('destination') ? Session::get('destination') : 'undefined' }}"
	:me="{{ Auth::check() ? Auth::user() : 'undefined' }}" 
></Application>

<!-- Beautifull Background -->
<Background></Background>

<!-- Navigation -->
<Navbar></Navbar>

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
