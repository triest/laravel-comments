<template>
  <div class="body" v-bind:style="[comment.parent_id!=null  ? {pagination:15} : {pagination:0}]">
    <div class="body-top">
      <div class="header">
        <div class="right-block">
          <div class="control">
            <a href="javascript://" data-reply-rating="minus" data-reply-rating-id="1211953"
               title="Оценить комментарий"><i class="fa fa-minus"></i></a>
            <span class="comment-rating comment-plus" data-reply-show-user-id="1211953">
                                    {{ comment.created_at }}
             <span class="answerButton" v-on:click="showAnswerForm(comment.id)">ответить</span>
            </span>
            <a href="javascript://" data-reply-rating="plus" data-reply-rating-id="1211953"
               title="Оценить комментарий"><i class="fa fa-plus"></i></a>
          </div>
        </div>
      </div>

    </div>

    <div class="text">
      {{ comment.text }}
    </div>
    <div v-if="showAnswerFormVariable===true">
      <textarea id="answer" :name="'comment'+comment.id" ref="'comment'+comment.id"
                v-model="comment_text"></textarea><br>
      <button value="Ответить" v-on:click="answer(comment.id)">Ответить</button>
    </div>
    <div v-if="getChild(comment)">
      <comment :comments="childdsGett" :childs="childs"></comment>
    </div>

  </div>
</template>

<script>
export default {
  props: {
    comment: {
      type: Object,
      required: false
    },
    comments: {
      type: Array,
      required: false
    },
    childs: {
      type: Array,
      required: false
    },
  },
  data() {
    return {
      first: true,
      childdsGett: [],
      showAnswerFormVariable: false
    }
  },
  mounted() {

  },
  computed: {},
  methods:
      {
        checkChild(item) {
          for (let i = 0; i < this.childs.length; i++) {
            if (this.childs[i].parent_id == item.id) {
              return true;
            }
          }
          return false;
        },
        getChild(item) {
          for (let i = 0; i < this.childs.length; i++) {
            if (item.id === this.childs[i].parent_id) {
              this.childdsGett.push(this.childs[i])
            }
          }
          return true;
        },
        showAnswerForm(comment_id) {
          this.showAnswerFormVariable = true;
        },
        answer(comment_id) {
          let that = this;
          axios.post('api/comment', {'parent_id': comment_id, 'text': this.comment_text}).then(function (data) {
             console.log(data.data)
             that.childdsGett.push(data.data)

          }).catch()
        }
      }
}
</script>

<style scoped>
.comment-rating {
  color: dimgray;
  font-family: Roboto;
}

.text {
  color: grey;
  font-family: Roboto;
}

.answerButton {
  cursor: pointer;
}
</style>
