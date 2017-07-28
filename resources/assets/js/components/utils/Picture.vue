<template>
<div v-if="src" class="text-center">

  <!-- Picture -->
  <div
    @click="zoomed = true"
    :class="['img-circle clickable zoomable background-image', preview ? 'image-border-danger' : 'image-border']"
    :style="'background-image: url(' + src + '); width: ' + (width || 200) + 'px; height: ' + (height || 200) + 'px;'" 
    :title="title"
  ></div>

  <!-- Modal -->
  <Modal :show="zoomed" :src="src" :title="title"></Modal>

</div>
</template>

<script>
import Modal from '../utils/Modal';
export default {
  name: 'picture',
  props: ['title', 'src', 'preview', 'width', 'height'],
  components: {
    Modal
  },
  data() {
    return {
      zoomed: false
    }
  }
}
</script>