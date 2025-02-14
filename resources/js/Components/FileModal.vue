<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-content">
      <!-- Tombol Close di pojok kanan atas -->
      <button class="close-btn" @click="$emit('close')">✖</button>
      
      <h3 class="text-lg font-bold mb-4">Pilih Sumber Foto</h3>

      <!-- Opsi Kamera & Galeri secara horizontal -->
      <div class="btn-container">
        <button @click="selectCamera" class="btn-option">
          📷 <span>Kamera</span>
        </button>
        <button @click="selectGallery" class="btn-option">
          🖼 <span>Galeri</span>
        </button>
      </div>

      <!-- Input file tersembunyi -->
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
/* Overlay latar belakang redup dan tidak bisa diklik */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5); /* Efek redup */
  display: flex;
  align-items: flex-end;
  justify-content: center;
  pointer-events: auto; /* Hindari klik di luar modal */
}

/* Modal muncul di bagian bawah */
.modal-content {
  background: #fff;
  width: 100%;
  max-width: 400px;
  border-radius: 12px 12px 0 0;
  padding: 20px;
  text-align: center;
  position: relative;
}

/* Tombol Close di pojok kanan atas */
.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #555;
  transition: 0.3s;
}

.close-btn:hover {
  color: #000;
}

/* Tombol Kamera & Galeri secara horizontal */
.btn-container {
  display: flex;
  justify-content: space-around;
  margin-top: 15px;
}

/* Style tombol */
.btn-option {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 12px;
  width: 140px;
  border-radius: 10px;
  border: none;
  background: #f3f3f3;
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
}

.btn-option:hover {
  background: #e0e0e0;
}

.btn-option span {
  margin-top: 5px;
  font-size: 14px;
}
</style>
