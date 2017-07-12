@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel" style="word-wrap: break-word;">

				<div class="panel-heading">
					<h1 class="card-title">Logs</h1>
					<hr>
					<form method="POST" action="{{ Config::get('services.server.php_self') . '/logs' }}">
						<button class="btn btn-danger">Delete Logs</button>
						<input type="hidden" name="_method" value="DELETE">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</form>
				</div>

				<div class="panel-body">
					@if(count($lines))
					@foreach($lines as $line)
					@if($line != '')
						{{ $line }}<br>
					@endif
						<!-- {!! $line !!}<br> -->
					@endforeach
					@else
					<p>Empty</p>
					@if(Session::has('message'))
						<br>
						<div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
					@endif
					@endif
				</div>

			</div>
		</div>
	</div>
</div>

@endsection
