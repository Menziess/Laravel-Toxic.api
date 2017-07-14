import Vue from 'vue';
import Vuex from 'vuex';
import Post from './Models/Post';

Vue.use(Vuex);

const views = ['posts', 'searchPosts', 'post'];

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
  objectifyJsonArray: jsonArray => jsonArray.map(post => new Post(post)),
  original(post) {
    if (!post instanceof Post) throw Error('post instanceof Post');
    return (!post.parent);
  },
  slugSameAsSearch(slug) {
    return state.searchPosts[0] ?
      slug === state.searchPosts[0].slug : false;
  },
  // Determines whether an id exists in any of the three views
  existsInView(id, view) {
    return find.indexById(state[view], id);
  },
  // Generic callback function applied to all posts with same id
  // that are found in any of the views defined in the view
  // array located at the top of this file.
  forEachViewHavingId(id, func) {
    let index = -1;
    views.map(view => {
      index = execute.existsInView(id, view);
      if (index !== -1)
        func(state[view], index);
    })
  },

  addReplyDetailPage(post) {          //TODO
    alert('tba');
  },
  deleteReplyDetailPage(post) {       //TODO
    alert('tba');
  },
  updateLikesDetailPage(post) {       //TODO
    alert('tba');
  }
}

/**
 * Modifying store state.
 */
const mutations = {
  likeDislike(state, post) {
    Post.parsePost(post);
    if (execute.original(post)) {
      execute.forEachViewHavingId(
        post.id,
        (array, index) => {
          array[index].copyLikeDislike(post);
        }
      )
    } else {
      execute.updateLikesDetailPage(post);
    }
  },
  delete(state, post) {
    Post.parsePost(post);
    if (execute.original(post)) {
      execute.forEachViewHavingId(
        post.id,
        (array, index) => {
          array.splice(index, 1)
        }
      )
    } else {
      execute.deleteReplyDetailPage(post);
    }
  },

  // If it's an original post, it's added to views, else
  // it's parents reply_count is updated in all views
  unshift(state, jsonPost) {
    const post = new Post(jsonPost);
    if (execute.original(post)) {
      if (execute.slugSameAsSearch(post.slug))
        state.searchPosts.unshift(new Post(jsonPost));
      state.posts.unshift(new Post(jsonPost));
    } else {
      execute.addReplyDetailPage(new Post(jsonPost));
      execute.forEachViewHavingId(
        post.parent,
        (array, index) => array[index].attributes.replies_count++
      )
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
      context.commit('likeDislike', response.data.data[0]);
    });
  },
  dislike(context, data) {
    return axios({
      method: 'post',
      url: 'api/post/dislike/' + data.id,
      data: data.type
    }).then(response => {
      context.commit('likeDislike', response.data.data[0]);
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