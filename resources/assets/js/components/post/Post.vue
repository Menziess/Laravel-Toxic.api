<template>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">

        <!-- Subject -->
        <div class="panel-heading">
            <router-link :to="'/t/' + post.attributes.slug + '/' + post.id">
              <span><strong>{{ post.attributes.subject }}</strong></span>
            </router-link>
        </div>

        <!-- Post Details -->
        <PostDetails :username="post.relationships.user.name" :userslug="post.relationships.user.slug" :userpic="post.relationships.user.picture"></PostDetails>
        
        <!-- Post Content -->
        <Textbox      v-if="post.attributes.attachment === 'text'" :text="post.attributes.text"></Textbox>
        <Drawing v-else-if="post.attributes.attachment === 'drawing'" ref="myDrawing"></Drawing>
        <p v-else-if="post.attributes.attachment === 'url'">{{ post.attributes.url }}</p>
        <p v-else-if="post.attributes.attachment === 'video'">{{ post.attributes.url }}</p>
        <p v-else-if="post.attributes.attachment === 'image'">{{ post.attributes.url }}</p>

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
  import PostDetails from './utils/PostDetails.vue';
  import Drawing from './children/Drawing.vue';
  import Textbox from './children/Textbox.vue';
  export default {
    name: 'post',
    props: ['id', 'post'],
    components: {
      PostDetails,
      Drawing,
      Textbox,
    },
    methods: {
      deletePost() {
				axios({
					method: 'delete',
					url: '/api/post/' + this.post.id
				}).then(response => {
					location.reload();
					console.error(response)
				}).catch(error => {
					console.error(error)
				});
      },
    },
    mounted() {
      switch (this.post.attributes.attachment) {
        case 'text':
          break;
        case 'drawing':
          this.$refs.myDrawing.renderDataUrl(this.post.attributes.drawing);
          break;
        default:
          break;
      }
    }
  }
</script>