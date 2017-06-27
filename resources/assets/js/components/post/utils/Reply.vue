<template>
  <div class="panel-separator">

    <!-- Post Details -->
    <PostDetails :username="reply.user.name" :userslug="reply.user.slug" :userpic="reply.user.picture"></PostDetails>
    
    <!-- Post Content -->
    <Textbox      v-if="reply.attachment === 'text'" :text="reply.text"></Textbox>
    <Drawing v-else-if="reply.attachment === 'drawing'" ref="myDrawing"></Drawing>
    <p v-else-if="reply.attachment === 'url'">{{ reply.url }}</p>
    <p v-else-if="reply.attachment === 'video'">{{ reply.url }}</p>
    <p v-else-if="reply.attachment === 'image'">{{ reply.url }}</p>

    <!-- Buttons -->
    <!--<button v-on:click="deleteReply()" type="button" class="btn btn-danger pull-right">Delete</button>-->

  </div>
</template>

<script>
  import PostDetails from './PostDetails.vue';
  import Drawing from '../children/Drawing.vue';
  import Textbox from '../children/Textbox.vue';
  export default {
    name: 'reply',
    props: ['id', 'reply'],
    components: {
      PostDetails,
      Drawing,
      Textbox,
    },
    methods: {
      deleteReply() {
				axios({
					method: 'delete',
					url: '/api/post/' + this.post.id
				}).then(response => {
					this.$store.commit('deletePostById', this.post.id);
				}).catch(error => {
          this.$emit('error', error);
				});
      },
    },
    mounted() {
      switch (this.reply.attachment) {
        case 'text':
          break;
        case 'drawing':
          this.$refs.myDrawing.renderDataUrl(this.reply.drawing);
          break;
        default:
          break;
      }
    }
  }
</script>