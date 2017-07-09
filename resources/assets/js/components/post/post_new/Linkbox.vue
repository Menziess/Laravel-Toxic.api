<template>
  <div class="panel-content">
    <input class="form-control"
      :placeholder="placeholder ? placeholder : 'www...'"
      :maxlength="maxlength"
      autofocus="autofocus"
      v-model="url" 
      type="url" 
    >
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
