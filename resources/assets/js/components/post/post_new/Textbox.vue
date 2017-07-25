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
        text: this.$parent.text,
        maxlength: 255,
        hasInput: false
      }
    },
    watch: {
      text() {
        if (this.text.length !== 0 && !this.hasInput) {
          this.hasInput = true;
          this.$emit('hasInput', this.hasInput);
        }
        if (this.text.length < 1) {
          this.hasInput = false;
          this.$emit('hasInput', this.hasInput)
        }
      }
    }
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
