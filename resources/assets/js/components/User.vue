<template>
  <div>

    <router-view></router-view>
    <h1>User {{ $route.params.slug }}</h1>
    
  </div>
</template>

<script>
export default {
  name: 'user'
}
</script>
