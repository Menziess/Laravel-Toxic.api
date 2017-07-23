<template>
<div v-if="me" class="panel text-center">
  <div class="panel-body">
    <img 
      class="img-circle clickable image-border"
      :src="me.picture"
      :title="me.name" 
      width="200px"
      height="200px"
      data-toggle="modal" 
      data-target="#myModal"
    >
    <hr>
    <div class="btn-group" role="group">
      <label class="btn btn-primary" disabled>
         <span id="browse">Browse</span><input id="file" name="file" data-max-size="4000" accept="image/*" value="" type="file" style="display: none;"> 
      </label>
    </div>

  <!-- Modal -->
  <div id="myModal" class="modal fade noselect" role="dialog">
    <img 
      class="img-circle"
      :src="me.picture"
      :title="me.name"
      width="100%"
      data-toggle="modal"
      data-target="myModal"
    >
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
