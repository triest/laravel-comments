<template>
    <comment :comments="comments" :childs="child"></comment>
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
          let temp=null;
          axios.get('api/comment')
              .then((response) => {
                temp=response.data;
                this.comments = temp.root;
                this.child = temp.child;
              });

        },
        getChild(parent_id) {

        }
      }
}
</script>

<style scoped>

</style>
