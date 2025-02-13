<template>
  <div class="bg-white min-h-screen">
    <!-- Header (Fixed) -->
    <div class="bg-blue-600 text-white text-center py-4 font-bold text-lg fixed top-0 left-0 w-full z-50">
      Inspeksi Mobil
    </div>

    <!-- Tabs Menu (Fixed) -->
    <div class="overflow-x-auto whitespace-nowrap bg-gray-100 border-b flex scrollbar-hide fixed top-12 left-0 w-full z-40" ref="categoryContainer">
      <button v-for="(category, index) in categories" 
        :key="category.id"
        @click="selectCategory(category, index)"
        class="flex-shrink-0 px-4 py-3 border-b-2"
        :class="activeTab === index ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500'">
        {{ category.name }} ({{ filledCounts[category.id] || 0 }}/{{ category.inspection_points.length }})
      </button>
    </div>

    <!-- Content -->
    <div class="p-4 mt-20"> <!-- Tambah margin agar tidak tertutup header -->
      <div v-if="inspectionPoints.length">
        <div v-for="point in inspectionPoints" :key="point.id" class="mt-4">
          <label class="block text-sm font-medium">{{ point.name }}</label>

<!-- Input Text -->
<input v-if="point.type_input === 'Input Text'" type="text" 
  v-model="formData[point.id]" 
  class="w-full border px-3 py-2 rounded-lg mt-1" 
  :placeholder="point.placeholder"
  @input="formData[point.id] = $event.target.value.toUpperCase()" />

        

        <!-- Input Number -->
        <input v-if="point.type_input === 'Input Number'" type="number" v-model="formData[point.id]" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          :placeholder="point.placeholder" />

        <!-- Input Account (formatted as currency) -->
        <input v-if="point.type_input === 'Input Account'" type="text" v-model="formData[point.id]" 
          @input="formatCurrency(point.id)"
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          :placeholder="point.placeholder" />

        <!-- Input Tanggal -->
        <input v-if="point.type_input === 'Tanggal'" type="date" v-model="formData[point.id]" 
          class="w-full border px-3 py-2 rounded-lg mt-1" />

          <!-- Option "Ada" / "Tidak Ada" -->
          <div v-if="point.type_input === 'Option to Foto'" class="mt-2 flex justify-center gap-4">
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
 <div v-if="point.type_input === 'Foto' || formData[point.id] === 'Ada'" >
       <p class="text-xs text-gray-500">File JPG berukuran maks 2,5 MB</p>
        <div class="photo-upload" @click="openModal(index)">
          <img v-if="point.file" :src="point.file" alt="Foto" class="photo-preview" />
          <div v-else class="upload-placeholder">
            <i class="icon-upload"></i>
            <p>Upload Foto</p>
          </div>

      </div>
    </div>

        </div>
      </div>
    </div>
  </div>
  
  <!-- Komponen Modal -->
  <FileModal 
    :isVisible="showModal" 
    @close="showModal = false" 
    @camera="openCamera" 
    @gallery="openGallery" 
  />
</template>

<style scoped>
/* Hilangkan scrollbar */
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* Styling agar lebih smooth */
button:focus {
  outline: none;
}

/* Sembunyikan input file asli */
input[type="file"] {
  display: none;
}

.photo-section {
  margin-bottom: 20px;
}
.upload-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px dashed #ccc;
  padding: 20px;
  text-align: center;
}
.photo-preview {
  width: 100%;
  max-width: 250px;
  border-radius: 5px;
}
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
  border-radius: 5px;
  text-align: center;
}
</style>

<script>
import { ref, computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import FileModal from "@/components/FileModal.vue";

export default {
  setup() {
    const page = usePage();
    const categories = ref(page.props.categories);
    const activeTab = ref(0);
    const inspectionPoints = ref(categories.value.length ? categories.value[0].inspection_points : []);
    const formData = ref({});
    const filledCounts = ref({});
    const categoryContainer = ref(null);
    const showModal = ref(false);
    const selectedFilePoint = ref(null);

    const selectCategory = (category, index) => {
      activeTab.value = index;
      inspectionPoints.value = category.inspection_points.filter(point => point.is_active);
      initializeFormData();
      scrollToActiveCategory();
    };

    const initializeFormData = () => {
      formData.value = {};
      inspectionPoints.value.forEach(point => {
        formData.value[point.id] = "";
      });
    };

    const scrollToActiveCategory = () => {
      if (categoryContainer.value) {
        const activeButton = categoryContainer.value.children[activeTab.value];
        if (activeButton) {
          categoryContainer.value.scrollTo({
            left: activeButton.offsetLeft - categoryContainer.value.offsetWidth / 2 + activeButton.offsetWidth / 2,
            behavior: "smooth",
          });
        }
      }
    };

    const toggleOption = (id, value) => {
      formData.value[id] = value;
    };

    const openModal = (pointId) => {
      selectedFilePoint.value = pointId;
      showModal.value = true;
    };

    const openCamera = () => {
      showModal.value = false;
      console.log("Membuka Kamera...");
    };

    const openGallery = () => {
      showModal.value = false;
      console.log("Membuka Galeri...");
    };

    onMounted(() => {
      scrollToActiveCategory();
    });

    return {
      categories,
      activeTab,
      inspectionPoints,
      formData,
      selectCategory,
      filledCounts,
      categoryContainer,
      showModal,
      selectedFilePoint,
      toggleOption,
      openModal,
      openCamera,
      openGallery,
    };
  },
  components: { FileModal },
  methods: {
    formatCurrency(id) {
      let value = this.formData[id].replace(/\D/g, ""); // Hapus semua yang bukan angka
      value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambahkan titik setiap 3 angka
      this.formData[id] = value;
    },
  
  }
};
</script>
