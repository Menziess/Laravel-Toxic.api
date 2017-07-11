import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

/**
 * Contains methods to find elements in arrays.
 */
// const find = {
//   elementById(array, id) {
//     return array.find(element => {
//       return element.id === id;
//     });
//   },
//   indexById(array, id) {
//     return array.map(element => {
//       return element.id;
//     }).indexOf(id);
//   },
//   addPost(array, post) {
//     // If top parent
//     if (!post.attributes.post_id) {
//       array.unshift(post); 
//     } 
//     // else reply to some parent
//     else {
//       const parentId = post.attributes.post_id;
//       const parent = find.elementById(array, parentId);
      
//       if (!parent) return;

//       if (parent.relationships.replies) {
//         parent.relationships.replies.unshift(post);
//       } else {
//         parent.relationships.replies = [ post ];
//       }
//     }
//   },
//   deletePost(array, post) {
//     // If top parent
//     if (!post.attributes.post_id) {
//       const index = find.indexById(array, post.id);
//       array.splice(index, 1);
//     } 
//     // else delete some child
//     else {
//       const parentId = post.attributes.post_id;
//       const parent = find.elementById(array, parentId);

//       if (!parent) return;

//       const replies = parent.relationships.replies;
//       const index = find.indexById(replies, post.id);
//       replies.splice(index, 1);
//     }
//   }
// }


/**
 * Store data.
 */
const state = {
  topics: [

  ],
  searchPosts: [

  ],
  posts: [

  ],
  post: [

  ],
  me: null,
  search: null,
  hasMore: true,
  replying: null,
  logoutRoute: null,
  loginRoute: null,
  destinationRoute: null,
  error: null,
};


/**
 * Getters.
 */
const getters = {
  replying: state => { return state.replying; },
  destinationRoute: state => { return state.destinationRoute; },
  logoutRoute: state => { return state.logoutRoute; },
  loginRoute: state => { return state.loginRoute; },
  topics: state => { return state.topics; },
  error: state => { return state.error; },
  hasMore: state => { return state.hasMore; },
  posts: state => { return state.posts; },
  postsLast: state => { return state.posts[state.posts.length - 1]; },
  post: state => { return state.post; },
  searchPosts: state => { return state.searchPosts; },
  searchPostsLast: state => { return state.searchPosts[state.searchPosts.length - 1]; },
  search: state => { return state.search; }, 
  me: state => { return state.me; },
};


/**
 * Modifying store.
 */
const mutations = {

  // Create
  unshift(state, data) {
    const post = data[0];

    if (post.attributes.post_id) {
      alert("tba");
    } else {
      state.posts.unshift(data[0]);
    }

  },
  push(state, data) {
    state[data.name].push.apply(state[data.name], data.collection); 
  },
  replace(state, data) { 
    state[data.name] = data.collection;
  },
  like(state, post) {
    alert('tba');
  },
  dislike(state, post) {
    alert('tba');
  },

  // Delete
  cleanup(state, data) {
    if (state[data.name].length > 7)
    state[data.name] = state[data.name].splice(0, 7);
  },
  delete(state, post) {
    alert("tba");
  },

  // addSearchPost(state, post) { find.addPost(state.searchPosts, post); },
  // addPost(state, post) { find.addPost(state.posts, post); },

  // Other
  toggleReplying(state, id) { state.replying = id; },
  hasMore(state, boolean) {state.hasMore = boolean; },
  setDestination(state, route) { state.destinationRoute = route; },
  setTopics(state, topics) { state.topics = topics; },
  setLogout(state, route) { state.logoutRoute = route; },
  setLogin(state, route) { state.loginRoute = route; },
  setSearch(state, search) { state.search = search; },
  setMe(state, me) { state.me = me; },
  error(state, error) { state.error = error; },
};


/**
 * API for talking to store.
 */
const actions = {

  // Create
  new(data) {
    console.log(data);
    return axios({
      method: 'post',
      url: data.endpoint,
      data: data.post
    });
  },
  create(context, data) {
    return actions.new(data).then(response => {
      context.commit('unshift', response.data.data);
    });
  },
  like(context, data) {
    return axios({
      method: 'post',
      url: 'api/post/like/' + data.id,
      data: data.type
    }).then(response => {
      context.commit('like', data.id);
    });
  },
  dislike(context, data) {
    return axios({
      method: 'post',
      url: 'api/post/dislike/' + data.id,
      data: data.type
    }).then(response => {
      context.commit('dislike', data.id);
    });
  },

  // Get
  fetch(context, data) {
    return axios.get(data.endpoint)
    .then(response => {
      if (response.data.data.length > 0)
      context.commit(data.mutation, {
        name: data.name, 
        collection: response.data.data
      });
      else context.commit('hasMore', false);
    });
  },

  // Delete
  cleanup(context, data) { context.commit('cleanup', data); },
  delete(context, data) {
    return axios({
      method: 'delete',
      url: data.endpoint
    }).then(response => {
      context.commit('delete', data.post);
    });
  },
  deleteUser(context, id) {
    return axios({
      method: 'delete',
      url: '/api/user/' + id
    }).then(response => {
      context.commit('setMe', null);
    });
  },


  // Other
  toggleReplying(context, id) { context.commit('toggleReplying', id); },
  resetHasMore(context) { context.commit('hasMore', true); },
  setDestination(context, route) { context.commit('setDestination', route); },
  setLogout(context, route) { context.commit('setLogout', route); },
  setSearch(context, search) { context.commit('setSearch', search); },
  setTopics(context, topics) { context.commit('setTopics', topics); },
  setLogin(context, route) { context.commit('setLogin', route); },
  setMe(context, me) { context.commit('setMe', me); },
  error(context, error) { context.commit('error', error); },
};


export default new Vuex.Store({
  state,
  getters,
  mutations,
  actions,
});