
export class Post {
  
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
}

export class Drawing extends Post {
  constructor(data) {
    super(data);
  }

  get drawing() {
    return this.attributes.drawing;
  }
}

export class Link extends Post {
  constructor(data) {
    super(data);
  }
}
