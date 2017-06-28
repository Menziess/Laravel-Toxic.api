import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
  posts: [

  ],
  me: null,
  destination: null,
};

const getters = {
  // Posts
  posts: state => { return state.posts; },
  getPostById: (state, getters) => (id) => { return state.posts.find(post => post.id === id); },

  // Me
  me: state => { return state.me; },

  // Destination
  destination: state => { return state.destination; },
};

const mutations = {
  // Posts
  setInitialPosts(state, posts) { state.posts = posts; },
  deletePostById(state, id) {
    let remove = state.posts.map(post => {
      return post.id;
    }).indexOf(id);
    state.posts.splice(remove, 1);
  },
  addPost(state, post) { state.posts.unshift(post); },

  // Me
  setMe(state, me) { state.me = me; },

  // Destination
  setDestination(state, destination) { state.destination = destination; },
};

export default new Vuex.Store({
  state,
  getters,
  mutations
});