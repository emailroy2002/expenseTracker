<template>
  <div>

    <div>Current User is :: {{ user }}.</div>

    <p>Hello World!</p>
  </div>
</template>


<script>


export default {
  name: "Hello",
  props: {
    user: Object,
    message: String
  },  
  components: {  }
};
</script>