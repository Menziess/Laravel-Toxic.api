<template>
<div class="details">

  <!-- Left Side -->
  <div class="leftist">
    <img
      @click="zoomed = true"
      class="img-circle clickable zoomable image-border"
      :src="me ? me.picture : '/img/default.png'"
      :title="me ? me.name : 'Anonymous'" 
      width="48"
      height="48"
    >
  </div>

  <!-- Modal -->
  <Modal v-if="me"
    :show="zoomed"
    :src="me.picture"
    :title="me.name" 
  ></Modal>

  <!-- Right Mid Side -->
  <div class="mid">
    <textarea
      ref="textarea"
      maxlength="170"
      placeholder="Write something here..."
      autofocus="autofocus"
      v-model="$parent.text"
    >
    </textarea>
  </div>
</div>
</template>

<script>
import Modal from '../../utils/Modal';
export default {
  name: 'textbox',
  props: ['text'],
  components: {
    Modal
  },
  data() {
    return {
      zoomed: false
    }
  },
  watch: {
    text() {
      if (this.$refs.textarea.clientHeight < this.$refs.textarea.scrollHeight) {
        this.$refs.textarea.style.height = this.$refs.textarea.scrollHeight + "px";
        if (this.$refs.textarea.clientHeight < this.$refs.textarea.scrollHeight)
        {
          this.$refs.textarea.style.height = 
            (this.$refs.textarea.scrollHeight * 2 - this.$refs.textarea.clientHeight) + "px";
        }
      }
    }
  },
  computed: {
    me() { return this.$store.getters.me; }
  }
}
</script>

<style scoped>
textarea {
  padding: 0.5em;
  resize: none;
  width: 100%;
  min-height: 6em;

  outline: none;
  border: none;

  line-height: 1.5;
  font-size: larger;
}
textarea::placeholder {
  color: #ccd0d2;
}
</style>
