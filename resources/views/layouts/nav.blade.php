<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        
        <!-- Branding Image -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Toxic') }}
            </a>
        </div>

        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
            <!--<li class="active"><a href="#">Home</a></li>-->
            <!--<li><a href="#">Link</a></li>-->
            <!--<button class="btn btn-secondary navbar-btn">Post</button>-->
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <li>
                <!-- Profile Picture -->
                <a class="navbar-brand" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                    @if (Auth::guest())
                    <svg class="img-circle noselect profile-pic profile-pic-nav"/>
                    @else
                    <img class="img-circle noselect profile-pic-nav"                     
                        src="{{ asset(Auth::user()->getPicture()) }}"
                        alt="Profile picture"/>
                    @endif
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu" role="menu">
                    <li>
                        @if (Auth::guest())
                        <a href="{{ route('login.facebook') }}">Register</a>
                        @else
                        <a href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        @endif
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>