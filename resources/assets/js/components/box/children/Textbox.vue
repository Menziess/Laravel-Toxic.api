<template>
  <div class="panel-content">
    <textarea ref="myTextarea"

      :maxlength="maxlength"
      autofocus="autofocus"
      
    >
    </textarea>
  </div>
</template>

<script>
  export default {
    name: 'textbox',
    data() {
      return {
        textarea: null
      }
    },
    props: ['display', 'maxlength'],
    methods: {
      
    },
    mounted () {
      this.textarea = this.$refs.myTextarea;
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
