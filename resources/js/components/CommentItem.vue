<template>
  <div class="body" v-bind:style="[comment.parent_id!=null  ? {pagination:15} : {pagination:0}]">
    <div class="body-top">
      <div class="header">
        <div class="right-block">
          <div class="control">
            <a href="javascript://" data-reply-rating="minus" data-reply-rating-id="1211953"
               title="Оценить комментарий"><i class="fa fa-minus"></i></a>
            <span class="comment-rating comment-plus" data-reply-show-user-id="1211953" style="inline">
               <span class="avatar">
                  <img src="images/avatar.jpg" alt="avatar" width="30" height="30">
                     {{  }}
                 <span>
                            <i class="css-clock"></i>
</span> {{ time(comment.created_at) }}

                    <span class="answerButton" v-on:click="showAnswerForm(comment.id)">ответить</span>
                 {{ likesNum }}
                 <button
                     v-on:click="newLike(comment.id)">like</button>
                   <button v-on:click="dislike(comment.id)">dislike</button>
               </span>

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
      showAnswerFormVariable: false,
      likesNum: 0
    }
  },
  mounted() {
    this.calculate_likes();
  },

  methods:
      {
        calculate_likes() {
          let accum = 0;
          //    console.log("likes")
          //    console.log(this.comment.like);
          for (let i = 0; i < this.comment.like.length; i++) {
            console.log(this.comment.like[i])
            accum += this.comment.like[i].value
          }
          this.likesNum = accum;
        },

        newLike(comment_id) {
          let that = this;
          axios.post('api/comment/like', {'comment_id': comment_id, 'action': 'like'}).then(function (data) {
            console.log(data.data.result)
            if (data.data.result === true) {
              that.likesNum = that.likesNum + 1;
            }
            console.log(that.likesNum);
          }).catch()
        },
        dislike(comment_id) {
          let that = this;
          axios.post('api/comment/like', {'comment_id': comment_id, 'action': 'dislike'}).then(function (data) {
            console.log(data.data.result)
            if (data.data.result === true) {
              that.likesNum = that.likesNum - 1;
            }
            console.log(that.likesNum);
          }).catch()
        },
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
          if (!this.showAnswerFormVariable) {
            this.showAnswerFormVariable = true;
          } else {
            this.showAnswerFormVariable = false;
          }
        },
        answer(comment_id) {
          let that = this;
          axios.post('api/comment', {'parent_id': comment_id, 'text': this.comment_text}).then(function (data) {
            let data2 = data.data;

            that.childdsGett.push(data2[0])
          }).catch()
        },
        time(time) {

          var date1 = new Date(time);
          var date2 = new Date();


          var Time = date2.getTime() - date1.getTime();
          var Hours = Time / (60 * 60 * 1000);
          var Days = Time / (3600 * 24 * 1000);
          var Minutes = Time / (60 * 1000)


          if (Days >= 1) {
            return Math.round(Days) + " дня назад"
          }

          if (Hours >= 1) {
            return Math.round(Hours) + " чаc. назад"
          }

          if (Minutes > 1) {
            return Math.round(Minutes) + " мин. назад"
          }

          let sec = Time / (1000 * 60 * 60);

          if (sec < 1) {
            return "только что";
          }

          return sec + " ceк. назад"
        }

      }
}
Vue.filter('moment-ago', function (date) {
  return moment(date).fromNow()
})
</script>

<style lang="scss" scoped>
.comment-rating {
  color: dimgray;
  font-family: Roboto;
}

.text {
  color: grey;
  font-family: Roboto;
}

.avatar {
  flex: 1;
  display: flex;

  img {
    width: 30px;
    height: 30px;
    border-radius: 70%;
    margin-right: 10px;
  }
}

.answerButton {
  cursor: pointer;
}

.avatar {
  flex: 1;
  display: flex;

  img {
    width: 30px;
    height: 30px;
    border-radius: 70%;
    margin-right: 10px;
  }
}

.wrapper {
  margin: 0 auto;
  background-color: transparent;
  width: 1px;
  display: inline-block;
}

.css-clock {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background-color: transparent;
  border-color: red;
  filter: alpha(Opacity=70);
  border: 1rem solid;
  border-color: white;
  border-width: thin;
  position: relative;
  display: block;

  &::before {
    content: "";
    height: 6px;
    width: 2px;
    background-color: white;
    display: block;
    position: absolute;
    left: 9px;
    top: 3px;
    opacity: 0.6;
  }

  &::after {
    content: "";
    height: 5px;
    width: 2px;
    background-color: white;
    display: block;
    position: absolute;
    top: 7px;
    left: 11px;
    transform: rotate(135deg);
    opacity: 0.6;
  }


}
</style>
