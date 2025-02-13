<template>
  <div class="p-4">
    <div v-if="inspectionPoints.length">
      <div v-for="point in inspectionPoints" :key="point.id" class="mt-4">
        <label class="block text-sm font-medium">{{ point.name }}</label>

        <!-- Input Text -->
        <input v-if="point.type_input === 'Input Text'" type="text" v-model="formData[point.id]"
          class="w-full border px-3 py-2 rounded-lg mt-1"
          :placeholder="point.placeholder" />

        <!-- Input Number -->
        <input v-if="point.type_input === 'Input Number'" type="number" v-model="formData[point.id]"
          class="w-full border px-3 py-2 rounded-lg mt-1"
          :placeholder="point.placeholder" />

        <!-- Input Account dengan Format -->
        <input v-if="point.type_input === 'Input Account'" type="text"
          v-model="formData[point.id]" @input="formatCurrency(point.id)"
          class="w-full border px-3 py-2 rounded-lg mt-1"
          :placeholder="point.placeholder" />

        <!-- Input Tanggal -->
        <input v-if="point.type_input === 'Tanggal'" type="date" v-model="formData[point.id]"
          class="w-full border px-3 py-2 rounded-lg mt-1"
          :placeholder="point.placeholder" />

        <!-- Input File (Foto) dengan Modal -->
        <div v-if="point.type_input === 'Foto'" class="mt-2">
          <div v-if="formData[point.id]" class="relative">
            <img :src="formData[point.id]" class="w-32 h-32 object-cover rounded" />
            <button @click="removeImage(point.id)" class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 rounded">X</button>
          </div>
          <button v-else @click="openFileOptions(point.id)" class="border p-3 rounded-lg flex items-center justify-center w-16 h-16 bg-gray-200">
            <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 5v14M5 12h14"></path>
            </svg>
          </button>
        </div>

        <!-- Select Ada / Tidak Ada -->
        <select v-if="point.type_input === 'Select'" v-model="formData[point.id]" class="w-full border px-3 py-2 rounded-lg mt-1">
          <option value="">Pilih</option>
          <option value="Ada">Ada</option>
          <option value="Tidak Ada">Tidak Ada</option>
        </select>

        <!-- Jika "Ada" dipilih, tampilkan input file seperti sebelumnya -->
        <div v-if="point.type_input === 'Select' && formData[point.id] === 'Ada'" class="mt-2">
          <button @click="openFileOptions(point.id)" class="border p-3 rounded-lg flex items-center justify-center w-16 h-16 bg-gray-200">
            <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 5v14M5 12h14"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Pilihan Kamera/Galeri -->
  <div v-if="showFileOptions" class="fixed inset-0 bg-black bg-opacity-50 flex items-end">
    <div class="w-full bg-white p-4 rounded-t-lg">
      <button class="w-full py-3 flex items-center justify-center border-b" @click="takePhoto">
        📷 Buka Kamera
      </button>
      <button class="w-full py-3 flex items-center justify-center border-b" @click="selectFromGallery">
        🖼️ Pilih dari Galeri
      </button>
      <button class="w-full py-3 text-red-500 font-bold" @click="showFileOptions = false">
        Tutup
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {},
      showFileOptions: false,
      selectedFilePoint: null
    };
  },
  props: {
    inspectionPoints: Array
  },
  methods: {
    formatCurrency(pointId) {
      let value = this.formData[pointId].replace(/\D/g, ''); // Hanya angka
      value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambahkan titik pemisah
      this.formData[pointId] = value;
    },
    openFileOptions(pointId) {
      this.selectedFilePoint = pointId;
      this.showFileOptions = true;
    },
    takePhoto() {
      alert("Fitur Buka Kamera belum diimplementasikan!");
      this.showFileOptions = false;
    },
    selectFromGallery() {
      alert("Fitur Pilih dari Galeri belum diimplementasikan!");
      this.showFileOptions = false;
    },
    removeImage(pointId) {
      this.formData[pointId] = null;
    }
  }
};
</script>

<style scoped>
/* Modal Animation */
.fixed {
  transition: all 0.3s ease-in-out;
}
</style>
