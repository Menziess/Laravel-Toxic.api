import Vue from 'vue';
import Vuex from 'vuex';
import { Post, Drawing, Link } from './Models/Post';

Vue.use(Vuex);

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
 * Helpers for finding elements in arrays.
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
  },
  // addPost(array, post) {
  //   // If top parent
  //   if (!post.attributes.post_id) {
  //     array.unshift(post); 
  //   } 
  //   // else reply to some parent
  //   else {
  //     const parentId = post.attributes.post_id;
  //     const parent = find.elementById(array, parentId);
      
  //     if (!parent) return;

  //     if (parent.relationships.replies) {
  //       parent.relationships.replies.unshift(post);
  //     } else {
  //       parent.relationships.replies = [ post ];
  //     }
  //   }
  // },
  // deletePost(array, post) {
  //   // If top parent
  //   if (!post.attributes.post_id) {
  //     const index = find.indexById(array, post.id);
  //     array.splice(index, 1);
  //   } 
  //   // else delete some child
  //   else {
  //     const parentId = post.attributes.post_id;
  //     const parent = find.elementById(array, parentId);

  //     if (!parent) return;

  //     const replies = parent.relationships.replies;
  //     const index = find.indexById(replies, post.id);
  //     replies.splice(index, 1);
  //   }
  // }
}

/**
 * Helpers for manipulating posts.
 */
const execute = {
  objectifyJsonArray: jsonArray => { 
    return jsonArray.map(jsonObject => { 
      return execute.objectifyJsonObject(jsonObject);
    }); 
  },
  objectifyJsonObject: jsonObject => {
    if (jsonObject.attributes.attachment === 'drawing')
      return new Drawing(jsonObject);
    if (jsonObject.attributes.attachment === 'url')
      return new Link(jsonObject);
    return new Post(jsonObject);
  },
  original(post) {
    return (!post.parent);
  },
  slugSameAsSearch(slug) {
    return state.searchPosts[0] ?
      slug === state.searchPosts[0].slug : false;
  },
  existsInHome(id) {
    return find.indexById(state.posts, id);
  },
  existsInSearch(id) {
    return find.indexById(state.searchPosts, id);
  },
  existsInDetail(id) {
    return find.indexById(state.post, id);
  },
  updateReplyCount(post) {
    let index = execute.existsInHome(post.parent);
    if (index !== -1) {
      const parent = state.posts[index];
      parent.attributes.replies_count++;
      state.posts[index] = parent;
    }
    index = execute.existsInSearch(post.parent);
    if (index !== -1) {
      const parent = state.searchPosts[index];
      parent.attributes.replies_count++;
      state.searchPosts[index] = parent;
    }
    index = execute.existsInDetail(post.parent);
    if (index !== -1) {
      const parent = state.post[index];
      parent.attributes.replies_count++;
      state.post[index] = parent;
    }
  },
  addReplyDetailPage(post) {
    alert('tba');
  }
}

/**
 * Modifying store state.
 */
const mutations = {
  like(state, post) {
    alert('tba');
  },
  dislike(state, post) {
    alert('tba');
  },
  delete(state, post) {
    alert("tba");
  },
  unshift(state, jsonPost) {
    // If it's not an original post, the reply count must
    // be updated of the parent post for every view.
    const post = execute.objectifyJsonObject(jsonPost);
    if (!execute.original(post)) {
      execute.updateReplyCount(post);
      execute.addReplyDetailPage(post);
    } else {
      // It must be added to home and search views
      if (execute.slugSameAsSearch(post.slug))
        state.searchPosts.unshift(post);
      state.posts.unshift(post);
    }
  },
  push(state, data) {
    state[data.name].push.apply(state[data.name], execute.objectifyJsonArray(data.collection)); 
  },
  replace(state, data) { 
    state[data.name] = execute.objectifyJsonArray(data.collection);
  },
  cleanup(state, data) {
    if (state[data.name].length > 7)
    state[data.name] = state[data.name].splice(0, 7);
  },
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
  new(data) {
    return axios({
      method: 'post',
      url: data.endpoint,
      data: data.post
    });
  },
  create(context, data) {
    return actions.new(data).then(response => {
      context.commit('unshift', response.data.data[0]);
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