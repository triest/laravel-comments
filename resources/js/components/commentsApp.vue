<template>
  <div class="container">
    <textarea class="main-textarea" v-model="comment_text" placeholder="Введите сообщение!"></textarea><br><br>
    <button @click="send">Отправить</button>
    <br>
    <span class="comment-label">
    Комментарии
    </span>
    <button class="sort-span" v-on:click="changeOrder('popular')"
            v-bind:style="{ 'background-color': order==='popular' ? '#19191e' : '#101013' ,'color': order==='popular' ?  '#9f9fa1':'#65656e'  }">
      Популярные
    </button>
    <button class="sort-span" v-on:click="changeOrder('new')"
            v-bind:style="{ 'background-color': order==='new' ? '#19191e' : '#101013' ,'color': order==='new' ?  '#9f9fa1':'#65656e'  }">
      Новые
    </button>
    <button class="sort-span" v-on:click="changeOrder('old')"
            v-bind:style="{ 'background-color': order==='old' ? '#19191e' : '#101013' ,'color': order==='old' ?  '#9f9fa1':'#65656e'  }">
      Старые
    </button>
    <use xlink:href="#icon--ui__share"></use>
    <span class="rules-span" style="text-align: right">
          &#9432;
         <span class="rules" style="text-align: right;position: relative;margin-right: 0px;max-width: 20px;width: 20px">Правила</span>
    </span>
    <comment :comments="comments" :childs="child" @new="getComments()" :user="user"></comment>
  </div>
</template>

<script>
export default {
  name: "commentsApp",

  data() {
    return {
      comments: null,
      child: null,
      order: 'popular',
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
          this.$emit('update');
        },
        send() {
          let that = this;
          axios.post('api/comment', {'text': this.comment_text}).then(function (data) {
            that.comments.push(data.data[0])
            that.comment_text = "";
          }).catch(function (error) {


            if (error.response.status === 403) {
              alert('Не авторизован')
            } else {
              alert(error.response.data.errors.text)
            }
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
 default background color #101013
 default-font-color #65656e
 active backgrounf color #19191e
 active font color #9f9fa1
 -->
<style scoped>

.main-textarea {
  width: 450px;
  height: 100px;
  resize: none;
}

.sort-span {
  cursor: pointer;
  background-color: #101013;
  border: 0px;
  color: #65656e;
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

.rules-span {
  position: relative;
  margin-left: 30px;
  color: #9f9fa1;
}

.container{
  font-family: Roboto,serif;
}
</style>
