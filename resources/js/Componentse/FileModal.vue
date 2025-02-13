<template>
  <div v-if="isVisible" class="fixed inset-0 flex items-end justify-center bg-black bg-opacity-50">
    <div class="bg-white p-4 rounded-t-lg w-full max-w-md">
      <div class="flex justify-between">
        <button @click="selectCamera" class="flex items-center gap-2 border px-4 py-2 rounded-lg">
          <i class="fas fa-camera"></i> Kamera
        </button>
        <button @click="selectGallery" class="flex items-center gap-2 border px-4 py-2 rounded-lg">
          <i class="fas fa-image"></i> Galeri
        </button>
      </div>
      <button @click="closeModal" class="absolute top-2 right-2 text-lg">&times;</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["isVisible"],
  emits: ["close", "camera", "gallery"],
  methods: {
    closeModal() {
      this.$emit("close");
    },
    selectCamera() {
      this.$emit("camera");
    },
    selectGallery() {
      this.$emit("gallery");
    }
  }
};
</script>
