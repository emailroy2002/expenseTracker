<template>
  <div>
    <Cropper
      ref="cropper"
      :src="src"
      :stencilComponent="$options.components.CircleStencil"
    />
  </div>
</template>

<script>
import { Cropper, CircleStencil } from "vue-advanced-cropper";

export default {
  name: "ImageCropper",
  props: {
    src: String
  },  
  components: {
    Cropper,
    CircleStencil
  }
};
</script>

<style scoped>
.img-container {
  width: 640px;
  height: 480px;
  float: left;
}
.img-preview {
  width: 200px;
  height: 200px;
  float: left;
  margin-left: 10px;
}
</style>