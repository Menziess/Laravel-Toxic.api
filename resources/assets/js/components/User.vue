<template>
  <div>

    <!-- Child page -->
    <div v-if="$route.params.slug">
      <router-view></router-view>
		</div>
    
    <!-- If no user selected, check own settings -->
    <div v-else>
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
