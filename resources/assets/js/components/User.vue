<template>
  <div>

    <!-- Name -->
    <div v-if="$route.params.slug">
			<h1 class="text-center subject">
				<small>/u/</small>
				{{ $route.params.slug }}
			</h1>
    <br>
    <router-view></router-view>
		</div>
    
    <div v-else>
      <h1 class="text-center subject">
				Settings
			</h1>
      <Settings></Settings>
    </div>

  </div>
</template>

<script>
import Settings from './user/Settings';
export default {
  name: 'user',
  components: {
    Settings
  }
}
</script>
