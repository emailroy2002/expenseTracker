<template>
  <div>
    <div>Current User is :: </div>
 
    <p>This is the homepage</p>


    <ExampleComponent></ExampleComponent>
  </div>
</template>

<script>
//Components Used Site Side


export default {
  name: "Messages",
  components: {  },
  props: {
    user: Object,
    test_message: String
  },
  mounted () {
    
  },
  computed: {
    newMessage: function() {
      return (this.test_message + " | " + "This is Appended ON messages")
    } 
  }
};
</script>