import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

/**
 * Contains methods to find elements in arrays.
 */
const find = {
  elementById(array, id) {
    return array.find(element => {
      return element.id === id;
    });
  },
  indexById(array, id) {
    return array.map(element => {
      return element.id;
    }).indexOf(id);
  }
}

/**
 * Modifying store.
 */
const mutations = {

  deletePost(state, post) {
     // If top parent
    if (!post.attributes.post_id) {
      const index = find.indexById(state.posts, post.id);
      state.posts.splice(index, 1);
    } 
    // else delete some child
    else {
      const parentId = post.attributes.post_id;
      const parent = find.elementById(state.posts, parentId);

      if (!parent) return;

      const replies = parent.relationships.replies;
      const index = find.indexById(replies, post.id);
      replies.splice(index, 1);
    }
  },

  addPost(state, post) { 
    // If top parent
    if (!post.attributes.post_id) {
      state.posts.unshift(post); 
    } 
    // else reply to some parent
    else {
      const parentId = post.attributes.post_id;
      const parent = find.elementById(state.posts, parentId);
      
      if (!parent) return;

      if (parent.relationships.replies) {
        parent.relationships.replies.unshift(post);
      } else {
        parent.relationships.replies = [ post ];
      }
    }
  },

  // Setters
  setInitialPosts(state, posts) { state.posts = posts; },
  setDestination(state, route) { state.destinationRoute = route; },
  setLogout(state, route) { state.logoutRoute = route; },
  setLogin(state, route) { state.loginRoute = route; },
  setPost(state, post) { state.post = post; },
  error(state, error) { state.error = error; },
  setMe(state, me) { state.me = me; },
};


const state = {
  posts: [

  ],
  post: null,
  me: null,
  logoutRoute: null,
  loginRoute: null,
  destinationRoute: null,
  error: null,
};


const getters = {
  destinationRoute: state => { return state.destinationRoute; },
  logoutRoute: state => { return state.logoutRoute; },
  loginRoute: state => { return state.loginRoute; },
  error: state => { return state.error; },
  posts: state => { return state.posts; },
  post: state => { return state.post; },
  me: state => { return state.me; },
};


const actions = {
  setDestination(context, route) { context.commit('setDestination', route); },
  deletePost(context, post) { context.commit('deletePost', post); },
  setLogout(context, route) { context.commit('setLogout', route); },
  setLogin(context, route) { context.commit('setLogin', route); },
  addPost(context, post) { context.commit('addPost', post); },
  setPost(context, post) { context.commit('setPost', post); },
  setMe(context, me) { context.commit('setMe', me); },
  error(context, error) { context.commit('error', error); },
};


export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions
});