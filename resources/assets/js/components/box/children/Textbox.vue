<template>
  <div class="panel-content">
    <textarea
      :maxlength="maxlength"
      v-model="text"
    >
    </textarea>
  </div>
</template>

<script>
  export default {
    name: 'textbox',
    data() {
      return {
        maxlength: 255,
        text: this.$parent.text
      }
    }
  }
</script>

<style scoped>
textarea {
  padding: 0.5em;
  resize: none;
  height: 40vh;
  width: 100%;

  border: none;

  line-height: 1.5;
  font-size: larger;
}
</style>
