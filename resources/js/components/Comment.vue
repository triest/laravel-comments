<template>
  <div class="container">
    <div class="site-comment" v-for="item in comments">
        <comment-item :comment="item" :comments="comments" :childs="childs"></comment-item>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    comments: {
      type: Array,
      required: false
    },
    childs: {
      type: Array,
      required: false
    }
  },
  data(){
    return {
      first: true
    }
  },
  mounted() {
    console.log('Component mounted.');
    console.log('comments')
    console.log(this.comments)
 //   this.getComments()
    console.log("child in comment")
    console.log(this.childs)
  },
  methods:
      {
        getComments() {
          axios.get('api/comment')
              .then((response) => {
                  this.comments=response.data.root;

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
