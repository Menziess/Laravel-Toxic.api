<template>
  <div ref="postview">
    <div :class="[ischild ? 'panel-separator' : '']">
      <div :class="[ischild ? '' : ['panel', 'panel-default']]">
        <div>

          <!-- Subject -->
          <div v-if="!ischild && $router.history.current.name === 'home'" class="panel-heading">
            <router-link :to="'/t/' + post.attributes.slug">
              <strong class="heading-text">/t/{{ post.attributes.subject }}</strong>
            </router-link>
          </div>

          <!-- Attachments -->
          <Attachments 
            :post="post"
          ></Attachments>

          <!-- Reply Form -->
          <PostReply v-if="replying === post.id" 
            :post="post"
          ></PostReply>

          <!-- Replies -->
          <div v-if="!hidereplies">
          <PostView v-for="post in post.relationships.replies"
            v-if="post.relationships && post.relationships.user"
            :ischild="true"
            :post="post"
            :key="post.id"
          ></PostView>
          </div>

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
    props: ['post', 'hidereplies', 'ischild'],
    components: {
      Attachments,
      PostReply,
      Drawing,
      Textbox
    },
    computed: {
      replying() {
        return this.$store.getters.replying;
      }
    }
  }
</script>