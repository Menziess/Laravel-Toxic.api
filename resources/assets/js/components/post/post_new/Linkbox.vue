<template>
  <div class="panel-content">
    <div class="inputs">
      <div class="input-group">
        <span class="input-group-addon" id="url-addon">url</span>
        <input class="form-control"
          aria-describedby="url-addon"
          maxlength="255"
          placeholder="Enter attachment url"
          autofocus="autofocus"
          v-model="$parent.url" 
          type="url" 
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'linkbox'
}
</script>

<style scoped>
.inputs {
  padding: 0.5em;
  min-height: 10em;
  width: 100%;
}
.input-group {
  margin: 4em;
}
</style>
