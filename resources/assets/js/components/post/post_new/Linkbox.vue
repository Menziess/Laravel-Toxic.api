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
      hasInput: false,
      url: this.$parent.url,
    }
  },
  watch: {
    url() {
      if (this.url.length !== 0 && !this.hasInput) {
        this.hasInput = true;
        this.$emit('hasInput', this.hasInput);
      }
      if (this.url.length < 1) {
        this.hasInput = false;
        this.$emit('hasInput', this.hasInput)
      }
    }
  }
}
</script>

<style scoped>
.inputs {
  padding: 0.5em;
  min-height: 10em;
  width: 100%;
}
.input-group {
  margin: 4em;
}
</style>
