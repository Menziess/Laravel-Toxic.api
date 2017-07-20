@extends('layouts.app')

@section('content')

<!-- Manages Important Stuff -->
<Application
	destination="{{ Session::has('destination') ? Session::get('destination') : 'undefined' }}"
	:topics="{{ json_encode($topics) }}"
	:me="{{ Auth::check() ? Auth::user() : 'undefined' }}" 
></Application>

<!-- Beautifull Background -->
<Background></Background>

<!-- Navigation -->
<Navbar v-if="$route.name !== 'landing'"></Navbar>

<!-- Content -->
<div class="container">
	<div class="row">

		<!-- Left Nav -->
		<div class="col-md-3" v-if="$route.name !== 'landing'">
			<Left></Left>
		</div>

		<!-- Views -->
		<router-view></router-view>

		<!-- Right Nav -->
		<div class="col-md-3" v-if="$route.name !== 'landing'">
			<Right></Right>
		</div>
		
	</div>
</div style="margin-bottom: 5em;">
@endsection
