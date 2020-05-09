<script>
module.exports = {

  isDuplicate: (needle, haystack) => {
    let duplicate = false;
    let duplicateIndex = null;
    let duplicateObject = {};
    for (var index = 0; index < haystack.length; index++) {
      if (needle === haystack[index].username) {
        duplicateObject = haystack[index];
        duplicate = true;
        duplicateIndex = index;
      }
    }
    return {duplicate, duplicateObject, duplicateIndex};
  },
  windowChatBoxLimit: () => {
      let maxChatboxLimit = 10;
      let w = window.innerWidth;
      let h = window.innerHeight;

      //consider margin in the calculations
      let marginWidth = 10;

      //Object Width's
      let userListWidth = 250 + marginWidth;
      let chatboxWidth = 300 + marginWidth;
      let counterDockWidth = 300 + marginWidth;
      let availableWidth = (w - userListWidth) - (counterDockWidth);
      let counter = (availableWidth / chatboxWidth);
      let boxLimit = (Math.ceil(counter) <= 0 ) ? 1 : Math.ceil(counter);     
      // console.log({w}, {h})      
      //console.log({boxLimit});

      if (boxLimit >= maxChatboxLimit) {
        return maxChatboxLimit;
      } else {
        return boxLimit;
      }
      
  }
};
</script>
