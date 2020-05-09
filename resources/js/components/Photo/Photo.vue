<template>
  <span>
    <span class="row justify-content-center">
      <span class="user-avatar" :class="(size) ? 'avatar-'+ size : 'avatar-md' ">
        <img
          ref="profilePhoto"
          :src="user.primary_photo.thumbnail"
          @error="imageLoadError"
        />
      </span>
    </span>
  </span>
</template>

<script>
export default {
  name: "Photo",
  data() {
    return {
      width: 50,
      height: 50,
      user: {
        primary_photo: {
          filename: this.default,
          filename: this.thumbnail
        }
      }
    };
  },
  props: {
    default: String,
    size: String
  },
  beforeCreate() {
   
  },
  methods: {
    imageLoadError: function() {
      // console.log({index})
     this.user.primary_photo.thumbnail = "storage/images/photos/thumbnail.jpg";
     // this.$forceUpdate();
    }
  }  
};
</script>

<style>
.user-avatar {
  overflow: hidden;
  border-radius: 50%;
  background: white;
  padding: 3px;
  box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
  transition: 0.1s ease-out;
  bottom: 0;
  left: 6px;
}

.avatar-md,
.avatar-med,
.avatar-medium {
  width: 200px;
  height: 200px;
}

.avatar-sm,
.avatar-small {
  width: 35px;
  height: 35px;
}

.user-avatar img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
}
</style>