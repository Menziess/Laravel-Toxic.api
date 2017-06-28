import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
  posts: [

  ],
  me: null,
  destination: null,
  error: null
};

const getters = {
  // Posts
  posts: state => { return state.posts; },
  getPostById: (state, getters) => (id) => { return state.posts.find(post => post.id === id); },

  // Me
  me: state => { return state.me; },

  // Destination
  destination: state => { return state.destination; },

  // Error
  error: state => { return state.error; },
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
  addReply(state, post) {
    console.log(post);

    // state.posts.unshift(post); 
  },

  // Me
  setMe(state, me) { state.me = me; },

  // Destination
  setDestination(state, destination) { state.destination = destination; },

  // Error
  setError(state, error) { state.error = error; },
};

const actions = {

    // Posts
  deletePostById(context, id) { context.commit('deletePostById', id); },
  addPost(context, post) { context.commit('addPost', post); },
  addReply(context, post) { context.commit('addReply', post); },

  // Me
  setMe(context, me) { context.commit('setMe', me); },

  // Destination
  setDestination(context, destination) { context.commit('setDestination', destination); },

  // Error
  setError(context, error) { context.commit('setError', error); },
}

export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions
});