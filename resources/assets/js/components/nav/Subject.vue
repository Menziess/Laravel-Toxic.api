<template>
  <div>
    <div v-if="$route.params.slug">
      <h1 class="text-center subject">
        {{ $route.params.slug }}
      </h1>
    </div>
  </div>
</template>

<script>
export default {
  name: 'subject'
}
</script>

<style scoped>
.subject {
  background-color: #30cf4f;
	margin-top: 0.3em;
	padding: 0.2em;
}
</style>
