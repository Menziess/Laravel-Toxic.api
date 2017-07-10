<template>
  <div class="panel-content">
    <div class="inputs">

      <input class="form-control"
        :placeholder="placeholder ? placeholder : 'Enter url here...'"
        :maxlength="maxlength"
        autofocus="autofocus"
        v-model="url" 
        type="url" 
      >
    </div>
  </div>
</template>

<script>
export default {
  name: 'linkbox',
  props: ['placeholder'],
  data() {
    return {
      maxlength: 255,
      url: this.$parent.url
    }
  },
  watch: {
    'url': 'hasInput'
  },
  methods: {
    hasInput() {
      if (this.url.length !== 0)
        this.$emit('hasInput', true);
      else
        this.$emit('hasInput', false);
    }
  }
}
</script>

<style scoped>
.inputs {
  padding: 0.5em;
  height: 272px;
  width: 100%;
}
</style>
