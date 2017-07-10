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
    },
    watch: {
      'text': 'hasInput'
    },
    methods: {
      hasInput() {
        if (this.text.length !== 0)
          this.$emit('hasInput', true);
        else
          this.$emit('hasInput', false);
      }
    }
  }
</script>

<style scoped>
textarea {
  padding: 0.5em;
  resize: none;
  height: 272px;
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
