<template>
  <div>

    <!-- Name -->
    <div v-if="$route.params.slug">
			<h1 class="text-center subject">
				<small>/u/</small>
				{{ $route.params.slug }}
			</h1>
		</div>
    
    <br>

    <router-view></router-view>

  </div>
</template>

<script>
export default {
  name: 'user',

}
</script>
