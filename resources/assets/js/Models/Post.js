
export default class Post {
  
  constructor(data) {
    if (data.type !== 'posts') 
      throw new TypeError('Wrong object type passed in Post constructor');

    this.id = data.id;
    this.attributes = data.attributes;
    this.relationships = data.relationships;
    
    this.user = data.relationships.user;
    this.topic = data.relationships.topic;
    this.replies = data.relationships.replies;
    this.conversation = data.relationships.conversation;
  }

  get slug() {
    return this.attributes.slug;
  }

  get parent() {
    return this.attributes.post_id;
  }

  get drawing() {
    return this.attributes.drawing;
  }

  static parsePost(data) {
    if (!data instanceof Post)
      data = new self(data);
  }

  copyLikeDislike(post) {
    this.attributes.likes_count = post.attributes.likes_count;
    this.attributes.dislikes_count = post.attributes.dislikes_count;
    this.relationships.likes[0].relationships.pivot.attributes.type 
      = post.relationships.likes[0].relationships.pivot.attributes.type;
  }
}
