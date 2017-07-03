@extends('layouts.app')

@section('content')

<!-- Manages Important Stuff -->
<Application
	logout="{{ route('logout') }}"
	login="{{ route('login') }}"
	destination="{{ Session::has('destination') ? Session::get('destination') : 'undefined' }}"
	:topics="{{ json_encode($topics) }}"
	:me="{{ Auth::check() ? Auth::user() : 'undefined' }}" 
></Application>

<!-- Beautifull Background -->
<Background></Background>

<!-- Navigation -->
<Navbar></Navbar>

<!-- Subject Bar -->
<Subject></Subject>

<!-- Content -->
<div class="container">
	<div class="row">
	
		<!-- Hidden Modal -->
		<PostNew></PostNew>

		<!-- Views -->
		<router-view></router-view>
		
	</div>
</div>
@endsection
