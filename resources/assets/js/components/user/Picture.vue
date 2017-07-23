<template>
<div v-if="me" class="panel text-center">
  <div class="panel-body">

    <!-- Picture -->
    <img 
      class="img-circle clickable zoomable image-border"
      :src="me.picture"
      :title="me.name" 
      width="200px"
      height="200px"
      data-toggle="modal" 
      data-target="#zoom"
    >

    <hr>

    <!-- Upload -->
    <div class="btn-group" role="group">
      <label class="btn btn-primary" disabled>
         <span id="browse">Browse</span><input id="file" name="file" data-max-size="4000" accept="image/*" value="" type="file" style="display: none;" ref="file"> 
      </label>
    </div>

    <!-- Modal -->
    <div id="zoom" class="modal fade noselect" role="dialog">
      <img 
        class="img-circle zoom"
        :src="me.picture"
        :title="me.name"
        data-toggle="modal"
        data-target="#zoom"
      >
    </div>

  </div>
</div>
</template>

<script>
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
  name: 'picture',
  props: ['me'],
  methods: {
    uploadPicture() {
      console.log(this.$refs.file.value);
    }
  }
}
</script>
