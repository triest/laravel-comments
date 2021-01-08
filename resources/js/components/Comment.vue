<template>
  <div class="container">
    <div class="site-comment" v-for="item in comments">
      <div class="body" v-bind:style= "[item.parent_id!=null  ? {pagination:15} : {pagination:0}]">
        <div class="body-top">
          <div class="header">
            <div class="right-block">
              <div class="control">
                <a href="javascript://" data-reply-rating="minus" data-reply-rating-id="1211953"
                   title="Оценить комментарий"><i class="fa fa-minus"></i></a>
                <span class="comment-rating comment-plus" data-reply-show-user-id="1211953">
                                    28                                </span>
                <a href="javascript://" data-reply-rating="plus" data-reply-rating-id="1211953"
                   title="Оценить комментарий"><i class="fa fa-plus"></i></a>
              </div>
            </div>
            <div class="title">
              <a href="/forum/members/zashkvarder.713998/activity/site-comments/">
                {{item.author}} </a>
              <a href="javascript://" class="comments-to" data-id="1211953">
                <span class="time" data-time="2020-09-29T12:45:43+03:00">{{item.created_at}}</span>
              </a>
            </div>
          </div>

        </div>

        <div class="text">
         {{item.text}}
        </div>

      </div>
    </div>



  </div>
</template>

<script>
export default {
  data() {
    return {
      comments: null,
      child: null
    }
  },
  mounted() {
    console.log('Component mounted.');
    this.getComments()
  },
  methods:
      {
        getComments() {
          axios.get('api/comment')
              .then((response) => {
                  this.comments=response.data.root;
                  this.child=response.data.child;
              });
        },
        getChild(parent_id){

        }
      }
}
</script>
<style>
body {
  background-color: black; /* Цвет фона веб-страницы */
}

.comments-new .body .body-top {
  display: flex;
  flex-direction: row;
  padding: 10px;
  background-color: #1e1f24;
}
</style>
