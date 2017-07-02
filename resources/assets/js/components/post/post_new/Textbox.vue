<template>
  <div class="panel-content">
    <textarea
      :placeholder="placeholder ? placeholder : 'Write something here...'"
      :maxlength="maxlength"
      autofocus="autofocus"
      v-model="text"
    >
    </textarea>
  </div>
</template>

<script>
  export default {
    name: 'textbox',
    props: ['placeholder'],
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
  height: 30vh;
  width: 100%;

  outline: none;
  border: none;

  line-height: 1.5;
  font-size: larger;
}

textarea::placeholder {
  color: #ccd0d2;
}
</style>
