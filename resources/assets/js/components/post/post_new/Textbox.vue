<template>
<div class="details">

  <!-- Left Side -->
  <div class="leftist">
    <img
      @click="zoomed = true"
      class="img-circle clickable zoomable image-border"
      :src="me ? me.picture : '/img/default.png'"
      :title="me ? me.name : 'Anonymous'" 
      width="48"
      height="48"
    >
  </div>

  <!-- Modal -->
  <Modal v-if="me"
    :show="zoomed"
    :src="me.picture"
    :title="me.name" 
  ></Modal>

  <!-- Right Mid Side -->
  <div class="mid">
    <div v-editor
      autofocus="autofocus"
      placeholder="Sup"
      contenteditable="true" 
      class="editor"></div> 
  </div>
</div>
</template>

<script>
import MediumEditor from 'medium-editor';
import Modal from '../../utils/Modal';
export default {
  name: 'textbox',
  components: {
    Modal
  },
  data() {
    return {
      zoomed: false,
      hashtagregex: /\S*#(?:\[[^\]]+\]|\S+)/
    }
  },
  computed: {
    me() { return this.$store.getters.me; }
  },
  methods: {
    hashtag(event) {
      console.log("hashtag");
    },
    atpersand(event) {
      console.log("atpersand");
    }
  },
  directives: {
    editor(el, binding, vnode) {
      const editor = new MediumEditor(el, {
        toolbar: false,
        autoLink: true,
        placeholder: false,
        disableReturn: true,
        disableExtraSpaces: true,
      });
      editor.subscribe('editableKeyup', event => {
        switch (event.keyCode) {
          case 51:
            break;
          case 50:
            break;
        }
      });
      editor.subscribe('editableInput', event => {
        console.log(el.html());
        vnode.context.$parent.text = event.target.innerText;
      });
    }
  }
}
</script>

<style scoped>
.editor {
  padding: 0.5em;
  resize: none;
  width: 100%;
  min-height: 6em;

  outline: none;
  border: none;

  line-height: 1.5;
  font-size: larger;

  word-wrap: break-word;
	word-break: break-all;
}
.editor:empty::before {
  content: attr(placeholder);
  opacity: .50;
}
</style>
