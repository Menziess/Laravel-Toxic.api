<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <!-- Subject -->
        <!--<div class="panel-heading">
            {{ subject }}
        </div>-->

        <!-- Attachments -->
        <Drawing v-if="attachment == 0" ref="myDrawing"></Drawing>
        <Textbox v-else-if="attachment == 1" :text="text"></Textbox>
        <p v-else-if="attachment == 2">{{ url }}</p>
        <p v-else-if="attachment == 3">{{ url }}</p>
        <p v-else-if="attachment == 4">{{ url }}</p>

        <!-- Buttons -->
        <div class="panel-footer">
          <button v-on:click="deletePost()" type="button" class="btn btn-danger pull-right">Delete</button>
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
    name: 'post',
    props: ['id', 'subject', 'attachment', 'drawing', 'text', 'url'],
    components: {
      Drawing,
      Textbox
    },
    methods: {
      deletePost() {
        let api_token = sessionStorage.getItem('api_token');
				axios({
					headers: { Authorization: 'Bearer ' + api_token },					
					method: 'delete',
					url: '/toxic.api/public/api/post/' + this.id
				}).then(response => {
					location.reload();
				}).catch(error => {
					console.error(error)
				});
      }
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