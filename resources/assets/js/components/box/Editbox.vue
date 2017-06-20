<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <div class="panel-heading">
          <span v-text="subject"></span>
        </div>

        <Drawing v-show="attachment === 0"></Drawing>
        <Textbox v-show="attachment === 1" :maxlength="maxlength"></Textbox>  

        <div class="panel-footer">
          <button type="button" v-on:click="attachment = 0" class="btn btn-secondary">Draw</button>
          <button type="button" v-on:click="attachment = 1" class="btn btn-secondary">Write</button>

          <button type="submit" class="btn btn-primary pull-right">Post</button>
          <div class="clearfix"></div>
        </div>     

      </div>
    </div>
  </div>
</template>

<script>
  import Drawing from './children/Drawing.vue';
  import Textbox from './children/Textbox.vue';
  export default {
    name: 'editbox',
    data() {
      return {
        attachment: 0,
        maxlength: 255,
        subject: 'bob'
      }
    },
    components: {
      Drawing,
      Textbox
    }
  }
</script>