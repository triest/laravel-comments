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
  mounted() {
    console.log('Component mounted.');
    this.getComments()
  },
  methods:
      {
        getComments() {
          let temp=null;
          axios.get('api/comment')
              .then((response) => {
                temp=response.data;
                console.log(temp)
                this.comments = temp.root;
                this.child = temp.child;
                console.log("child in main")
                console.log(this.child)
              });

        },
        getChild(parent_id) {

        }
      }
}
</script>

<style scoped>

</style>
