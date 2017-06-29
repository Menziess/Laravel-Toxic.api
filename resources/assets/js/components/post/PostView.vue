<template>
	<div :class="[original ? ['col-md-8', 'col-md-offset-2'] : 'panel-separator']">
		<div :class="[original ? ['panel', 'panel-default'] : '']">
      <div>

        <!-- Subject -->
        <!--<div class="panel-heading">
            <router-link :to="'/t/' + post.attributes.slug + '/' + post.id">
              <span><strong>{{ post.attributes.subject }}</strong></span>
            </router-link>
        </div>-->

        <!-- Post Details -->
        <PostContent 
          :post="post"
          v-on:reply="replying = !replying"
        ></PostContent>

        <!-- Reply Box -->
        <PostReply v-if="replying" :post="post"></PostReply>

        <!-- Post Replies -->
        <PostView v-for="post in post.relationships.replies"
          :key="post.id"
          :post="post"
        ></PostView>

      </div>
    </div>
  </div>
</template>

<script>
  import PostContent from './post_view/PostContent.vue';
  import PostReply from './PostReply.vue';
  import Drawing from './post_view/Drawing.vue';
  import Textbox from './post_view/Textbox.vue';
  export default {
    name: 'PostView',
    props: ['post'],
    components: {
      PostContent,
      PostReply,
      Drawing,
      Textbox
    },
    data() {
      return {
        replying: false
      }
    },
    computed: {
      original() {
        return !this.post.attributes.post_id;
      }
    }
  }
</script>

<style>
.reply {
  transform: scale(1, -1);
}
</style>