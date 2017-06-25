<nav class="navbar navbar-default navbar-static-top">
	<div class="container">

		<!-- Posts Feed -->
		<router-link to="/" tag="button" class="btn btn-secondary navbar-btn">
			Posts
		</router-link>

		<!-- Something else -->
		<router-link to="/u" tag="button" class="btn btn-secondary navbar-btn">
			Users
		</router-link>

		<!-- New Post -->
		<button type="button" class="btn btn-success navbar-btn pull-right" 
			data-toggle="modal" data-target="#newPost"
			title="Create a new post">New</button>

		<!-- Profile Picture -->
		<div class="dropdown pull-right">
			<a class="navbar-brand" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
				@if (Auth::guest())
				<span title="Register / Login"><svg class="img-circle noselect profile-pic profile-pic-nav"/></span>
				@else
				<img class="img-circle noselect profile-pic-nav"                     
					src="{{ Auth::user()->picture }}"
					alt="Profile picture"
					title="{{ Auth::user()->name }}" />
				@endif
			</a>
			
			<ul role="menu" class="dropdown-menu">
				@if (Auth::guest())
					<!-- Login -->
					<li role="presentation"><a href="{{ route('login.facebook') }}" role="menuitem">Login</a></li>
				@else
					<!-- Logout -->
					<li role="presentation"><a href="#" role="menuitem" onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">Logout</a>
					</li>
					<!-- CSRF -->
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				@endif
			</ul>
		</div>

	</div>
</nav>