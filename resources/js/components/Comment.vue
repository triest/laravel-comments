<template>
  <div class="container">

    <div class="site-comment" v-for="item in comments">
      <comment-item :comment="item" :comments="comments" :childs="childs" :user="user" @new="saveNewMessage"></comment-item>
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
    user: {
      type: Number,
      required: false
    },
    childs: {
      type: Array,
      required: false
    }
  },
  data() {
    return {
      first: true,
      message: ""
    }
  },
  created: function() {
    this.$parent.$on('update', this.setValue);
  },
  mounted() {

  },
  methods:
      {
        setValue: function(value) {
          this.$emit('update');
            console.log("setValue")
        },
        getChild(parent_id) {

        },
        saveNewMessage(message) {
          this.$emit('new', message);
        },
      }
}
</script>
<style>
body {
  background-color: #101013; /* Цвет фона веб-страницы */
}

.comments-new .body .body-top {
  display: flex;
  flex-direction: row;
  padding: 10px;
  background-color: #1e1f24;
}

.site-comment {
  max-width: 400px;
}
</style>
