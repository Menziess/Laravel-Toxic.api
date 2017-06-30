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

  deletePostById(state, id) {
    const remove = find.indexById(state.posts, id);
    state.posts.splice(remove, 1);
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

      console.log(post);

      if (parent.relationships.replies) {
        parent.relationships.replies.push(post);
      } else {
        let replies = [ post ];
        parent.relationships.replies = replies;
      }
    }
  },

  // Setters
  setInitialPosts(state, posts) { state.posts = posts; },
  setDestination(state, route) { state.destinationRoute = route; },
  setLogout(state, route) { state.logoutRoute = route; },
  setLogin(state, route) { state.loginRoute = route; },
  error(state, error) { state.error = error; },
  setMe(state, me) { state.me = me; },
};


const state = {
  posts: [

  ],
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
  me: state => { return state.me; },
};


const actions = {
  setDestination(context, route) { context.commit('setDestination', route); },
  deletePostById(context, id) { context.commit('deletePostById', id); },
  setLogout(context, route) { context.commit('setLogout', route); },
  setLogin(context, route) { context.commit('setLogin', route); },
  addPost(context, post) { context.commit('addPost', post); },
  setMe(context, me) { context.commit('setMe', me); },
  error(context, error) { context.commit('error', error); },
};


export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions
});