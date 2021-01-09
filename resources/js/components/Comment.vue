<template>
  <div class="container">
    <div class="composer">


    </div>
    <div class="site-comment" v-for="item in comments">
        <comment-item :comment="item" :comments="comments" :childs="childs" @new="saveNewMessage"></comment-item>
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
      first: true,
      message:""
    }
  },
  mounted() {

  },
  methods:
      {
        getComments() {
          this.comments=[];
          axios.get('comment')
              .then((response) => {
                  this.comments=response.data.root;
              });
        },
        getChild(parent_id){

        },
        saveNewMessage(message) {
          console.log("emited message")
          //console.log(message[0]);
          this.$emit('new', message);
        },
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
