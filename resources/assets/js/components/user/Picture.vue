<template>
<div v-if="me" class="panel text-center">
  <div class="panel-body">

    <!-- Picture -->
    <img 
      :class="['img-circle clickable zoomable', preview ? 'preview' : 'image-border']"
      :src="src"
      :title="me.name" 
      width="200px"
      height="200px" 
      data-toggle="modal" 
      data-target="#zoom"
    >

    <hr>

    <!-- Upload -->
    <div class="btn-group" role="group">
      <label class="btn btn-primary">
         <span>Browse</span><input accept="image/*" value="" type="file" style="display: none;" @change="setFile($event)" ref="file"> 
      </label>
      <button v-if="file" @click="upload()" class="btn btn-success">Upload</button>
      <button v-if="file" @click="clear()" class="btn btn-danger">Clear</button>
    </div>

    <!-- Modal -->
    <div id="zoom" class="modal fade noselect" role="dialog">
      <img 
        class="img-circle zoom"
        :src="src"
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
  data() {
    return {
      file: null,
      preview: null,
    }
  },
  computed: {
    src() {
      return this.preview ? this.preview : this.me.picture;
    }
  },
  methods: {
    setFile(event) {
      this.file = event.target.files[0];
      const reader = new FileReader();
      reader.onload = () => {
        this.preview = reader.result;
      }
      reader.readAsDataURL(this.file);
    },
    upload() {
      if (!this.file) return;
      const data = new FormData();
      data.append('file', this.file);
      axios({
        headers: { 'Content-Type': 'multipart/form-data; boundary=${data._boundary}' },
        method: 'post',
        url: 'api/user/picture',
        data: data,
        timeout: 10000,
      })
      .then(response => console.log(response))
      .catch(error => console.log(error.response.data.data));
    },
    clear() {
      this.$refs.file.value = '';
      this.preview = null;
      this.file = null;
    }
  }
}
</script>

<style scoped>
.preview {
  border: 2px solid red;
}
</style>