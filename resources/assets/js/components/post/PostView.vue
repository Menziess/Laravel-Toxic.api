<template>
	<div :class="[original ? ['col-md-8', 'col-md-offset-2'] : 'panel-separator']">
		<div :class="[original ? ['panel', 'panel-default'] : '']">
      <div>

        <!-- Subject -->
        <div v-if="!post.attributes.post_id" class="panel-heading">
            <router-link :to="'/t/' + post.attributes.slug + '/' + post.id">
              <strong class="heading-text">/t/{{ post.attributes.subject }}</strong>
            </router-link>
        </div>

        <!-- Attachments -->
        <Attachments 
          :post="post"
          v-on:reply="replying = !replying"
        ></Attachments>

        <!-- Reply Form -->
        <PostReply v-if="replying" 
          :post="post"
          v-on:submit="replying = !replying"
        ></PostReply>

        <!-- Replies -->
        <div v-if="!hidereplies">
        <PostView v-for="post in post.relationships.replies"
          :key="post.id"
          :post="post"
        ></PostView>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import Attachments from './post_view/Attachments.vue';
  import PostReply from './PostReply.vue';
  import Drawing from './post_view/Drawing.vue';
  import Textbox from './post_view/Textbox.vue';
  export default {
    name: 'PostView',
    props: ['post', 'hidereplies'],
    components: {
      Attachments,
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
        return true || !this.post.attributes.post_id;
      }
    }
  }
</script>

<style>
.reply { 
  transform: scale(1, -1);
}
.heading-text {
  margin-left: 4em;
}
</style>