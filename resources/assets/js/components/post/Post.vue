<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <!-- Subject -->
        <div class="panel-heading">
            <a :href="'/toxic.api/public/t/' + slug">{{ subject }}</a>
        </div>

        <!-- Attachments -->
        <Textbox v-if="attachment === 'text'" :text="text"></Textbox>
        <Drawing v-else-if="attachment === 'drawing'" ref="myDrawing"></Drawing>
        <p v-else-if="attachment === 'url'">{{ url }}</p>
        <p v-else-if="attachment === 'video'">{{ url }}</p>
        <p v-else-if="attachment === 'image'">{{ url }}</p>

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
    props: ['id', 'slug', 'subject', 'attachment', 'drawing', 'text', 'url'],
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
					console.error(response)
				}).catch(error => {
					console.error(error)
				});
      }
    },
    mounted() {
      switch (this.attachment) {
        case 'text':
          break;
        case 'drawing':
          this.$refs.myDrawing.renderDataUrl(this.drawing);
          break;
        default:
          break;
      }
    }
  }
</script>