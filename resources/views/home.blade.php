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

<!-- Content -->
<div class="container">
	<div class="row">
	
		<!-- Hidden Modal -->
		<PostNew></PostNew>

		<!-- Left Nav -->
		<div class="col-md-3">
			<Left></Left>
		</div>

		<!-- Views -->
		<router-view></router-view>

		<!-- Right Nav -->
		<div class="col-md-3">
			<Right></Right>
		</div>
		
	</div>
</div style="margin-bottom: 5em;">
@endsection
