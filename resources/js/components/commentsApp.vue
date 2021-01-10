<template>
  <div class="container">
    <textarea v-model="comment_text" placeholder="Введите сообщение!"></textarea><br><br>
    <button @click="send">Отправить</button>
    <span class="sort-span" v-on:click="changeOrder('popular')">Популярные</span>
    <span class="sort-span" v-on:click="changeOrder('new')">Новые</span>
    <span class="sort-span" v-on:click="changeOrder('old')">Старые</span>
    <comment :comments="comments" :childs="child" @new="getComments()" :user="user"></comment>
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
      type: Number,
      required: false
    },

  },
  mounted() {
    this.getComments()
    console.log("user in comments app");
  },
  methods:
      {
        getComments() {
          let temp = null;
          this.comments = [];
          this.child = []
          axios.get('api/comment', {params: {order: this.order}})
              .then((response) => {
                temp = response.data;
                this.comments = temp.root;
                this.child = temp.child;
              });

        },
        send() {
          let that = this;
          axios.post('api/comment', {'text': this.comment_text}).then(function (data) {
            that.comments.push(data.data[0])
            that.comment_text="";
          }).catch(function (){
            alert("Ошибка! Повторите позже или обратитесь к администратору")
            that.showAnswerFormVariable=false;
          })
        },
        changeOrder(order) {
          this.order = order;
          this.getComments();
        }
      }
}
</script>

<style scoped>
.sort-span {
  cursor: pointer;
  color: #76777c;
}

.container {
  font-family: Roboto, serif;
}
</style>
