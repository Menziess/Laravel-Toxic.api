<template>
  <div class="panel-content">
    <div class="inputs">
      <div class="input-group">
        <span class="input-group-addon" id="url-addon">url</span>
        <input class="form-control"
          aria-describedby="url-addon"
          :placeholder="placeholder ? placeholder : 'Enter attachment url'"
          :maxlength="maxlength"
          autofocus="autofocus"
          v-model="url" 
          type="url" 
        >
      </div>
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
.input-group {
  margin: 4em;
}
</style>
