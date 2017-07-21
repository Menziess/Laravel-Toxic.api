<template>
<div v-if="me" class="panel text-center">
  <div class="panel-body">
    <img 
      class="img-circle image-border"
      :src="me.attributes.picture"
      :title="me.attributes.name" 
      width="200px"
      height="200px"
    >
    <hr>
    <div class="btn-group" role="group">
      <label class="btn btn-primary" disabled>
         <span id="browse">Browse</span><input id="file" name="file" data-max-size="4000" accept="image/*" value="" type="file" style="display: none;"> 
      </label>
    </div>
  </div>
</div>
</template>

<script>
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
  name: 'picture',
  props: ['me']
}
</script>

<style scoped>
.img-circle {
  margin: auto;
}
</style>
