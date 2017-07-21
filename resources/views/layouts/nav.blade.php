<div class="navigation">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top"> 
      <div class="container">

        <!-- Posts Feed -->
        <a href="{{ Config::get('services.server.php_self') }}settings" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-home"></i>&ensp;<span class="mobile-hidden">Home</span>
        </a>

        <!-- Something else -->
        <!--<router-link to="/landing" tag="li" class="btn btn-secondary navbar-btn">
          <i class="glyphicon glyphicon-bell"></i>&ensp;<span class="mobile-hidden">Notifications</span>
        </router-link>-->

        <!-- Profile Picture -->
        <Picture></Picture>

      </div>
    </nav>
  </div>