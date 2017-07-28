<template>
  <div class="panel-content">
    <textarea
      maxlength="255"
      placeholder="Write something here..."
      autofocus="autofocus"
      v-model="$parent.text"
    >
    </textarea>
  </div>
</template>

<script>
  export default {
    name: 'textbox',
    props: ['text']
  }
</script>

<style scoped>
textarea {
  padding: 0.5em;
  resize: none;
  min-height: 10em;
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
