<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <!-- Subject -->
        <div class="panel-heading">
            {{ subject }}
        </div>

        <!-- Attachments -->
        <Drawing v-if="attachment == 0" ref="myDrawing"></Drawing>
        <p v-else-if="attachment == 1">{{ text }}</p>
        <p v-else-if="attachment == 2">{{ url }}</p>
        <p v-else-if="attachment == 3">{{ url }}</p>
        <p v-else-if="attachment == 4">{{ url }}</p>

        <!-- Buttons -->
        <div class="panel-footer">
          // placeholder
        </div>     

      </div>
    </div>
  </div>
</template>

<script>
  import Drawing from './children/Drawing.vue';
  export default {
    name: 'displaydrawing',
    props: ['subject', 'attachment', 'drawing', 'text', 'url'],
    components: {
      Drawing
    },
    mounted() {
      switch (parseInt(this.attachment)) {
        case 0:
          this.$refs.myDrawing.renderDataUrl(this.drawing);
          break;
        default:
          break;
      }
    }
  }
</script>