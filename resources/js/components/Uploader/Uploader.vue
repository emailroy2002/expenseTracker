<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        
        <ImageCropper :src="url" ref="ImageCropperComponent" class="mb-2 mt-2" />

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" @change="onFileChanged" class="custom-file-input" ref="fileUploader" />
            <label
              class="custom-file-label"
              for="inputGroupFile01"
              @change="onFileChanged"
            >{{ (this.selectedFile) ? this.selectedFile.name : "Select a file" }}</label>
          </div>
        </div>

        <!--
            <button type="button" class="btn btn-primary ">Small button</button>
            <button type="button" class="btn btn-secondary btn-sm">Small button</button>


            <div>
              <input type="file" @change="onFileChanged" ref="fileUploader" />
            </div>
        -->

        <div class="progress mt-2 mb-2" v-if="(this.uploadProgress > 0)">
          <div
            class="progress-bar"
            role="progressbar"
            v-bind:style="{ width: uploadProgress + '%'}"
            v-bind:aria-valuenow="uploadProgress"
            aria-valuemin="0"
            aria-valuemax="100"
          ></div>
        </div>

        <!--<button @click="onUpload" class="mb-2 mt-2">saveButton</button>-->
      </div>
    </div>
  </div>
</template>

<script>
//import io from "socket.io-client";

export default {
  data() {
    return {
      saveButton: "show",
      selectedFile: null,
      uploadProgress: 0,
      cropper: {},
      destination: null,
      url: null,
      image: {}
    };
  },
  mounted() {},
  methods: {
    onFileChanged(event) {
      this.selectedFile = event.target.files[0];

      //this.url = URL.createObjectURL(this.selectedFile);

      var reader = new FileReader();
      // Define a callback function to run, when FileReader finishes its job
      reader.onload = e => {
        // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
        // Read image as base64 and set to imageData
        this.url = e.target.result;
      };

      this.url = reader.readAsDataURL(this.selectedFile);
    },
    onUpload() {
      const {
        coordinates,
        canvas
      } = this.$refs.ImageCropperComponent.$refs.cropper.getResult();

      // You able to do different manipulations at a canvas
      // but there we just get a cropped image
      this.image = canvas.toDataURL();

      var base64ImageContent = this.image.replace(
        /^data:image\/(png|jpg);base64,/,
        ""
      );
      var blob = this.base64ToBlob(base64ImageContent, "image/png");

      // upload file, get it from this.selectedFile
      const formData = new FormData();

      //formData.append("image", this.selectedFile, this.selectedFile.name);

      formData.append("image", blob, this.selectedFile.name);

      axios
        .post("UploadController", formData, {
          onUploadProgress: progressEvent => {
            this.uploadProgress =
              (progressEvent.loaded / progressEvent.total) * 100;

            console.log(this.uploadProgress);
          }
        })
        .then(response => {
          if (this.uploadProgress >= 100) {
            var delayInMilliseconds = 1000; //1 second
            setTimeout(
              function() {
                this.uploadProgress = 0;
                this.$refs.fileUploader.value = "";
                this.selectedFile = "";
                this.url = "";

                // Update the Image
                this.$root.$refs.profileComponent.user.primary_photo.filename = response.data.image;
                this.$root.$refs.profileComponent.user.primary_photo.thumbnail = response.data.thumbnail;
                
                this.$forceUpdate();

                //Close the Modal
                this.$root.$refs.profileComponent.hideModal();
              }.bind(this),
              delayInMilliseconds
            );
          }

          console.log(response.data.image);
        });
    },

    base64ToBlob: function(base64, mime) {
      mime = mime || "";
      var sliceSize = 1024;
      var byteChars = window.atob(base64);
      var byteArrays = [];

      for (
        var offset = 0, len = byteChars.length;
        offset < len;
        offset += sliceSize
      ) {
        var slice = byteChars.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
          byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
      }

      return new Blob(byteArrays, { type: mime });
    }
  }
};
</script>

<style lang="scss" scoped>
.hide {
  display: none;
}
</style>
