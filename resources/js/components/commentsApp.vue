<template>
  <div  class="container">
    <textarea   v-model="comment_text" placeholder="Введите сообщение!"></textarea><br>
    <button  @click="send">Отправить</button>
    <comment :comments="comments" :childs="child"  @new="getComments()"></comment>
  </div>
</template>

<script>
export default {
  name: "commentsApp",

  data() {
    return {
      comments: null,
      child: null
    }
  },
  props: {
    user: {
      type: Object,
      required: false
    },

  },
  mounted() {
    this.getComments()
  },
  methods:
      {
        getComments() {
          let temp = null;
          console.log("getRootComment")
          this.comments=[];
          this.child=[]
          axios.get('api/comment')
              .then((response) => {
                temp = response.data;
                this.comments = temp.root;
                this.child = temp.child;
              });

        },
         send(){
           let that = this;
           axios.post('api/comment', {'text': this.comment_text}).then(function (data) {
             that.comments.push(data.data[0])
           }).catch()
         }
      }
}
</script>

<style scoped>

</style>
