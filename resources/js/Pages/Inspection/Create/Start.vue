<template>
  <div class="bg-white min-h-screen">
    <!-- Header (Fixed) -->
    <div class="bg-blue-600 text-white text-center py-4 font-bold text-lg fixed top-0 left-0 w-full z-50">
      Inspeksi Mobil
    </div>

    <!-- Tabs Menu (Fixed) -->
    <div class="overflow-x-auto whitespace-nowrap bg-gray-100 border-b flex scrollbar-hide fixed top-12 left-0 w-full z-40" ref="categoryContainer">
      <button 
        @click="selectDetailMobil"
        class="flex-shrink-0 px-4 py-3 border-b-2"
        :class="activeTab === -1 ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500'">
        Detail Mobil
      </button>
      <button v-for="(category, index) in categories" 
        :key="category.id"
        @click="selectCategory(category, index)"
        class="flex-shrink-0 px-4 py-3 border-b-2"
        :class="activeTab === index ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500'">
        {{ category.name }} ({{ filledCounts[category.id] || 0 }}/{{ category.inspection_points.length }})
      </button>
    </div>

    <!-- Content -->
    <div class="p-4 mt-20">
      <DetailMobil v-if="activeTab === -1" :detailMobilPoints="detailMobilPoints" :formData="formData" />
      <div v-else-if="inspectionPoints.length">
        <div v-for="point in inspectionPoints" :key="point.id" class="mt-4">
          <label class="block text-sm font-medium">{{ point.name }}</label>

          <!-- Input Text -->
          <input v-if="point.type_input === 'Input Text'" type="text" 
            v-model="formData[point.id]" 
            class="w-full border px-3 py-2 rounded-lg mt-1" 
            :placeholder="point.placeholder"
            @input="formData[point.id] = $event.target.value.toUpperCase()" />

          <!-- Input Account dengan Format -->
          <input v-if="point.type_input === 'Input Account'" type="text"
            v-model="formData[point.id]" @input="formatCurrency(point.id)"
            class="w-full border px-3 py-2 rounded-lg mt-1"
            :placeholder="point.placeholder" />

          <!-- Input Number -->
          <input v-if="point.type_input === 'Input Number'" type="number" 
            v-model="formData[point.id]" 
            class="w-full border px-3 py-2 rounded-lg mt-1" 
            :placeholder="point.placeholder" />

          <!-- Input Tanggal -->
          <input v-if="point.type_input === 'Tanggal'" type="date" 
            v-model="formData[point.id]" 
            class="w-full border px-3 py-2 rounded-lg mt-1" />

          <!-- Option "Ada" / "Tidak Ada" -->
          <div v-if="point.type_input === 'Option to Foto'" class="mt-2 flex justify-start gap-4">
            <button 
              @click="toggleOption(point.id, 'Ada')" 
              :class="{'bg-blue-500 text-white': formData[point.id] === 'Ada'}"
              class="border px-4 py-2 rounded-lg">Ada</button>
            <button 
              @click="toggleOption(point.id, 'Tidak Ada')" 
              :class="{'bg-blue-500 text-white': formData[point.id] === 'Tidak Ada'}"
              class="border px-4 py-2 rounded-lg">Tidak Ada</button>
          </div>

          <!-- Input File untuk Foto -->
          <div v-if="point.type_input === 'Foto' || formData[point.id] === 'Ada'" class="mt-3">
            <p class="text-gray-600 text-sm">File JPG berukuran maks 2,5 MB</p>

            <div class="flex items-center space-x-20">
              <!-- Review Foto -->
              <div v-if="formData[point.id + '_file']" class="w-40 h-32">
                <img :src="formData[point.id + '_file']" alt="Foto"
                  class="rounded-xl object-cover w-full h-full"
                  style="aspect-ratio: 4 / 3;" />
              </div>

              <!-- Tombol Hapus -->
              <button v-if="formData[point.id + '_file']"
                @click="removePhoto(point.id)"
                class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition">
                Delete
              </button>

              <!-- Tombol Upload -->
              <div v-else class="photo-upload border rounded-xl p-3 text-center cursor-pointer h-32 flex items-center w-full justify-center"
                @click="openModal(point.id)">
                <div class="upload-placeholder flex flex-col items-center">
                  <i class="icon-upload text-gray-400 text-3xl mb-2"></i>
                  <p class="text-gray-500">Upload Foto</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Komponen Modal Foto -->
    <FileModal 
      :isVisible="showModal" 
      @close="showModal = false" 
      @camera="openCamera" 
      @gallery="openGallery" 
      @fileSelected="handleFileUpload"
    />
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import FileModal from "@/components/FileModal.vue";
import DetailMobil from "@/components/DetailMobil.vue";

export default {
  components: { FileModal, DetailMobil },
  setup() {
    const page = usePage();
    const categories = ref(page.props.categories);
    const activeTab = ref(-1); // Default to Detail Mobil
    const inspectionPoints = ref([]);
    const detailMobilPoints = ref([
      { id: 'mobil_merek', name: 'Merek Mobil', type_input: 'Input Text', placeholder: 'Masukkan merek mobil' },
      { id: 'mobil_model', name: 'Model Mobil', type_input: 'Input Text', placeholder: 'Masukkan model mobil' },
      { id: 'mobil_tahun', name: 'Tahun Mobil', type_input: 'Input Number', placeholder: 'Masukkan tahun mobil' },
      { id: 'mobil_tanggal_pembelian', name: 'Tanggal Pembelian', type_input: 'Tanggal', placeholder: 'Pilih tanggal pembelian' }
    ]);
    const formData = ref({});
    const filledCounts = ref({});
    const showModal = ref(false);
    const selectedFilePoint = ref(null);

    const selectDetailMobil = () => {
      activeTab.value = -1;
      inspectionPoints.value = [];
    };

    const selectCategory = (category, index) => {
      activeTab.value = index;
      inspectionPoints.value = category.inspection_points.filter(point => point.is_active);
    };

    const toggleOption = (id, value) => {
      formData.value[id] = value;
    };

    const openModal = (pointId) => {
      selectedFilePoint.value = pointId;
      showModal.value = true;
    };

    const handleFileUpload = (fileUrl) => {
      if (selectedFilePoint.value !== null) {
        formData.value[selectedFilePoint.value + "_file"] = fileUrl;
        showModal.value = false;
      }
    };

    const removePhoto = (pointId) => {
      formData.value[pointId + "_file"] = null;
    };

    return {
      categories,
      activeTab,
      inspectionPoints,
      detailMobilPoints,
      formData,
      selectDetailMobil,
      selectCategory,
      filledCounts,
      showModal,
      selectedFilePoint,
      toggleOption,
      openModal,
      handleFileUpload,
      removePhoto
    };
  },
  methods: {
    formatCurrency(pointId) {
      let value = this.formData[pointId].replace(/\D/g, ''); 
      value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
      this.formData[pointId] = value;
    },
  }
};
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

button:focus {
  outline: none;
}

.photo-upload {
  border: 2px dashed #ccc;
  padding: 15px;
  text-align: center;
  border-radius: 10px;
}
</style>