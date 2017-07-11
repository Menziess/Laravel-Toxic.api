<template>
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

        <div ref="postreply">
          <PostReply
            v-if="replying === post.id" 
            :post="post"
          ></PostReply>
        </div>

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
    watch:  {
      replying() {
        if (this.replying !== this.post.id) return;
        this.scrollTo(window, this.$refs.postreply.offsetTop - 50, 2000);
      }
    },
    computed: {
      replying() {
        return this.$store.getters.replying;
      }
    },
    methods: {
      scrollTo(element, to, duration) {
        if (duration <= 0) return;
        const difference = to - element.scrollTop;
        const perTick = difference / duration * 10;

        setTimeout(function() {
            element.scrollTop = element.scrollTop + perTick;
            if (element.scrollTop === to) return;
            scrollTo(element, to, duration - 10);
        }, 10);
      }
    }
  }
</script>