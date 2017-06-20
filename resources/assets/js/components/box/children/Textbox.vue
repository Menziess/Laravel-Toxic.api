<template>
  <div class="panel-content">
    <textarea ref="myTextarea"

      :maxlength="maxlength"
      autofocus="autofocus"
      rows="2" 
      cols="2"
      
    ></textarea>
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
  resize: none;
  padding: 0.5em;
  line-height: 1.5;
  width: 100%;
  height: 40vh;
}
</style>
