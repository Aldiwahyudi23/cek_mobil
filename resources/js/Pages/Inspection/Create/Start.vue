<template>
  <div class="bg-white min-h-screen">
    <!-- Header -->
    <div class="bg-blue-600 text-white text-center py-4 font-bold text-lg">Inspeksi Mobil</div>

    <!-- Tabs Menu - Scrollable tanpa scrollbar -->
    <div class="overflow-x-auto whitespace-nowrap bg-gray-100 border-b flex scrollbar-hide" ref="categoryContainer">
      <button v-for="(category, index) in categories" 
        :key="category.id"
        @click="selectCategory(category, index)"
        class="flex-shrink-0 px-4 py-3 border-b-2"
        :class="activeTab === index ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500'">
        {{ category.name }} ({{ filledCounts[category.id] || 0 }}/{{ category.inspection_points.length }})
      </button>
    </div>

    <!-- Content -->
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

        <!-- Input File (Jika "Ada" dipilih) -->
        <div v-if="formData[point.id] === 'Ada'" class="mt-2 flex justify-center">
          <button @click="openModal" class="border p-2 rounded-lg flex items-center">
            <i class="fas fa-camera text-xl"></i>
          </button>
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
/* Sembunyikan input file asli */
input[type="file"] {
  display: none;
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

    const handleFileUpload = (pointId, event) => {
      formData.value[pointId] = event.target.files[0];
      updateFilledCount();
    };

    const updateFilledCount = () => {
      categories.value.forEach(category => {
        let filled = category.inspection_points.filter(point => formData.value[point.id]).length;
        filledCounts.value[category.id] = filled;
      });
    };

    // Scroll ke kategori yang aktif
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

    onMounted(() => {
      scrollToActiveCategory();
    });

    return {
      categories,
      activeTab,
      inspectionPoints,
      formData,
      selectCategory,
      handleFileUpload,
      filledCounts,
      categoryContainer,
       showModal: false,
      selectedFilePoint: null,
    };
  },
components: { FileModal },
  methods: {
    formatCurrency(id) {
      let value = this.formData[id].replace(/\D/g, ""); // Hapus semua yang bukan angka
      value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambahkan titik setiap 3 angka
      this.formData[id] = value;
    },
   toggleOption(id, value) {
      this.formData[id] = value;
    },
    openModal() {
      this.showModal = true;
    },
    openCamera() {
      this.showModal = false;
      console.log("Membuka Kamera...");
    },
    openGallery() {
      this.showModal = false;
      console.log("Membuka Galeri...");
    }
  }
};


</script>

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

/* Modal Animation */
.fixed {
  transition: all 0.3s ease-in-out;
}
</style>
