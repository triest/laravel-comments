<template>
  <div class="container">
    <textarea v-model="comment_text" placeholder="Введите сообщение!"></textarea><br><br>
    <button @click="send">Отправить</button>
    <br>
    <span class="comment-label">
    Комментарии
    </span>
    <button class="sort-span active" v-on:click="changeOrder('popular')">Популярные</button>
    <button class="sort-span" v-on:click="changeOrder('new')">Новые</button>
    <button class="sort-span" v-on:click="changeOrder('old')">Старые</button>
    <comment :comments="comments" :childs="child" @new="getComments()" :user="user"></comment>
    ::before
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
            that.comment_text = "";
          }).catch(function () {
            alert("Ошибка! Повторите позже или обратитесь к администратору")
            that.showAnswerFormVariable = false;
          })
        },
        changeOrder(order) {
          this.order = order;
          this.getComments();
        }
      }
}
</script>
<!--
 #19191e
 -->
<style scoped>
.sort-span {
  cursor: pointer;
  background-color:#101013;
  border: 0px;
  color: #707079;
}


.comment-label {
  font-size: 25px;
  color: #bbbbbd;
}



.card-body {
  background-size: cover;
  background-color: #19191e;
  width: 300px;
  height: 300px;
  color: #a2a2a5;
  cursor: pointer;
  border-radius: 5px;
}

.container {
  font-family: Roboto, serif;
}
</style>
