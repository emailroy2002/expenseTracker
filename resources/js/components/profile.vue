<template>
  <div class="profile-container">
    <div class="row justify-content-center">
      <div class="user-avatar">
        <img ref="profilePhoto" :src="user.primary_photo.filename" @error="imageLoadError" />
      </div>
    </div>

    <div class="row buttons-container mt-2 justify-content-center">
      <b-button id="show-btn" @click="showModal" class="justify-content-center">Upload Photo</b-button>
    </div>

    <b-modal ref="uploaderComponent-modal" size="lg" hide-footer title="Upload Profile Photo">
      <div class="d-block text-center">
        <Uploader ref="uploaderComponent"></Uploader>
      </div>

      <b-button class="mt-2" variant="outline-primary" block @click="savePhoto">Save</b-button>
      <!--<b-button class="mt-3" variant="outline-danger" block @click="hideModal">Close Me</b-button>-->
      <!--<b-button class="mt-2" variant="outline-warning" block @click="toggleModal">Toggle Me</b-button>-->
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        primary_photo: {
          filename: "/storage/images/photos/blank.jpg"
        }
      }
    };
  },
  mounted() {
    socket.on("registered", userPhotodata => {
      this.user = userPhotodata;
      //console.log(userPhotodata);
      this.$forceUpdate();
    });
  },
  methods: {
    savePhoto() {
      this.$refs.uploaderComponent.onUpload();
    },
    showModal() {
      this.$refs["uploaderComponent-modal"].show();
    },
    hideModal() {
      this.$refs["uploaderComponent-modal"].hide();
    },
    toggleModal() {
      // We pass the ID of the button that we want to return focus to
      // when the modal has hidden
      this.$refs["addSkills-modal"].toggle("#toggle-btn");
    },
    imageLoadError(event) {
        event.target.src = "/storage/images/photos/blank.jpg";
    }    
  }
};
</script>

<style scoped>
.user-avatar {
  width: 200px;
  height: 200px;
  overflow: hidden;
  border-radius: 50%;
  background: white;
  padding: 3px;
  box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
  transition: 0.1s ease-out;
  bottom: 0;
  left: 6px;
}

.user-avatar img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
}
</style>