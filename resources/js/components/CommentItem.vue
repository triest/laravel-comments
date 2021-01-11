<template>
  <div class="body" v-bind:style="[comment.parent_id!=null  ? {pagination:15} : {pagination:0}]">
      <div class="body-top">
        <div class="header">
          <div class="right-block">
            <div class="control">
              <a href="javascript://" data-reply-rating="minus" data-reply-rating-id="1211953"
                 title="Оценить комментарий"></a>
              <span class="comment-rating comment-plus" data-reply-show-user-id="1211953" style="inline">
               <span class="avatar">
                  <img src="images/avatar.jpg" alt="avatar" width="30" height="30">
                     {{  }}
                 <span>
                            <i class="css-clock"></i>
                </span> {{ time(comment.created_at) }}

                 <span class="answerButton" v-on:click="showAnswerForm(comment.id)">ответить</span>
                 <span class="like-span" style="text-align: right">
                 {{ likesNum }}
                  <span class="like grow" v-on:click="newLike(comment.id)">
                        <i class="fa fa-thumbs-up fa-1x like" aria-hidden="true" style="cursor: pointer;float: right"
                           v-bind:style="{'-webkit-text-stroke-color':colorLike}"></i>
                  </span>
                   <span class="dislike grow" v-on:click="dislike(comment.id)">
                        <i class="fa fa-thumbs-down fa-1x like" aria-hidden="true" style="cursor: pointer"
                           v-bind:style="{'-webkit-text-stroke-color':colorDislike}"></i>
                  </span>
                 </span>
               </span>

            </span>

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

      <comment :comments="childdsGett" :childs="childs"></comment>

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
    user: {
      type: Object,
      required: false
    },
  },
  data() {
    return {
      first: true,
      childdsGett: [],
      showAnswerFormVariable: false,
      likesNum: 0,
      colorLike: "dimgray",
      colorDislike: "dimgray"
    }
  },
  mounted() {
    this.calculate_likes();
    this.checkLike();
    this.checkDislike();
    this.getChild(this.comment)
  },

  methods:
      {
        checkLike() {
          if (typeof this.user == "undefined") {
            this.colorLike = "dimgray";
            return;
          }
          for (let i = 0; i < this.comment.like.length; i++) {
            if (this.comment.like[i].user_id === this.user.id && this.comment.like[i].value === 1) {
              this.colorLike = "green";
              return;
            }
          }
          this.colorLike = "dimgray"
        },
        checkDislike() {
          if (typeof this.user == "undefined") {
            this.colorDislike = "dimgray"
            return;
          }

          for (let i = 0; i < this.comment.like.length; i++) {
            if (this.comment.like[i].user_id === this.user && this.comment.like[i].value === -1) {
              this.colorDislike = "red";
              return;
            }

          }
          this.colorDislike = "dimgray"
        },
        calculate_likes() {
          let accum = 0;
          for (let i = 0; i < this.comment.like.length; i++) {
            accum += this.comment.like[i].value
          }
          this.likesNum = accum;
        },

        newLike(comment_id) {
          let that = this;
          let temp = null;
          axios.post('api/comment/like', {'comment_id': comment_id, 'action': 'like'}).then(function (data) {
            temp = data.data.result.value;
            that.colorDislike = "dimgray";
            if (temp === 0) {
              that.colorLike = "dimgray";
            } else if (temp === 1) {
              that.colorLike = "green";
            } else if (temp === -1) {
              that.colorLike = "red";
            }
            that.likesNum += 1;

          }).catch()
        },
        dislike(comment_id) {
          let that = this;
          let temp = null;
          axios.post('api/comment/like', {'comment_id': comment_id, 'action': 'dislike'}).then(function (data) {
            temp = data.data.result.value;
            that.colorLike = "dimgray";
            if (temp === 0) {
              that.colorDislike = "dimgray";
            } else if (temp === 1) {
              that.colorDislike = "green";
            } else if (temp === -1) {
              that.colorDislike = "red";
            }
            that.likesNum -= 1;
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
          console.log("redy to push")
          for (let i = 0; i < this.childs.length; i++) {
            console.log(this.childs);
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
            that.showAnswerFormVariable = false;
            that.childdsGett.push(data2[0]);
            that.comment_text = "";
          }).catch(function () {
            alert("Ошибка! Повторите позже или обратитесь к администратору")
            that.showAnswerFormVariable = false;
          })
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
</script>

<style lang="scss" scoped>
.v1 {
  border-left: 1px solid red;
}

li::before{
  border-left: 1px solid red;
}

.li{
  border-left: 1px solid white;
}

.fa-thumbs-up {
  -webkit-text-fill-color: transparent; /* Will override color (regardless of order) */
  -webkit-text-stroke-width: 1px;
  -webkit-text-stroke-color: white;
  float: right;
}

.like-span {
  position: absolute;
  margin-left: 400px;
  display: block;
}

.like {
  float: right;
}

.avatar{
  color: #949497;
}

.avatar.like {
  float: right;
}

.avatar.dislike {
  float: right;
}

.fa-thumbs-down {
  -webkit-text-fill-color: transparent; /* Will override color (regardless of order) */
  -webkit-text-stroke-width: 1px;
  -webkit-text-stroke-color: white;
  float: right;
}

.comment-rating {

  font-family: Roboto;
}

.text {
  color: #7f7f82;
  font-family: Roboto;
  word-wrap: break-word;
  width: 400px;
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
  width: 400px;

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

  .rating {
    display: inline-block;
    width: 100%;
    margin-top: 40px;
    padding-top: 40px;
    text-align: center;
  }

  .like,
  .dislike {
    display: inline-block;
    cursor: pointer;
    margin: 10px;
    border-color: white;
    border: 1px;
  }

  .dislike:hover,
  .like:hover {
    color: #2EBDD1;
    transition: all .2s ease-in-out;
    transform: scale(1.1);
    cursor: pointer;
  }

  .like {
    cursor: pointer;
  }

  .active {
    color: #2EBDD1;
  }

}
</style>
