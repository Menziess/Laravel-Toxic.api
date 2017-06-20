<template>
  <div class="panel-content">
    <textarea ref="myTextbox"

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
    data() {
      return {
        textarea: null,

        text: this.$parent.text
      }
    },
    props: ['display', 'maxlength'],
    methods: {
      
    },
    mounted () {
      this.textarea = this.$refs.myTextbox;
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
