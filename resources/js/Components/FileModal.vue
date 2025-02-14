<template>
  <div v-if="isVisible" class="modal">
    <div class="modal-content">
      <button class="close-btn" @click="$emit('close')">✖</button>
      <h3 class="text-lg font-bold mb-4">Pilih Sumber Foto</h3>
      <button @click="selectCamera" class="btn-option">📷 Kamera</button>
      <button @click="selectGallery" class="btn-option">🖼 Galeri</button>

      <input 
        type="file" 
        ref="cameraInput" 
        accept="image/*" 
        capture="environment" 
        @change="handleFileChange"
        style="display: none"
      />

      <input 
        type="file" 
        ref="galleryInput" 
        accept="image/*" 
        @change="handleFileChange"
        style="display: none"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: ["isVisible"],
  methods: {
    selectCamera() {
      this.$refs.cameraInput.click();
    },
    selectGallery() {
      this.$refs.galleryInput.click();
    },
    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        const fileUrl = URL.createObjectURL(file);
        this.$emit("fileSelected", fileUrl);
      }
    }
  }
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
}
.close-btn {
  background: none;
  border: none;
  font-size: 18px;
}
.btn-option {
  display: block;
  margin: 10px auto;
  padding: 10px;
  border-radius: 8px;
}
</style>
