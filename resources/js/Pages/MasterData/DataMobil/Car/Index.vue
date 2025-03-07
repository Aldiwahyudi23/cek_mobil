
<template>
    <div class="p-4">
        <!-- Bagian Header: Tombol Tambah & Pencarian -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
            <PrimaryButton @click="openModal('create')">Tambah Mobil</PrimaryButton>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <!-- Filter Brand -->
                <select v-model="selectedBrand" class="border rounded px-8 py-2">
                    <option value="">Semua Brand</option>
                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                        {{ brand.name }}
                    </option>
                </select>

                <!-- Filter Model -->
                <select v-model="selectedCarModel" class="border rounded px-8 py-2">
                    <option value="">Semua Model</option>
                    <option v-for="model in carModels" :key="model.id" :value="model.id">
                        {{ model.name }}
                    </option>
                </select>

                <!-- Filter Car Type -->
                <select v-model="selectedCarType" class="border rounded px-8 py-2">
                    <option value="">Semua Tipe</option>
                    <option v-for="type in carTypes" :key="type.id" :value="type.id">
                        {{ type.name }}
                    </option>
                </select>

                <!-- Pencarian -->
                <TextInput v-model="searchQuery" placeholder="Cari Mobil..." class="pl-10 pr-4 py-2 border rounded-md" />
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="min-w-full border bg-white rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Brand</th>
                        <th class="px-4 py-2 text-left">Model</th>
                        <th class="px-4 py-2 text-left">Tipe</th>
                        <th class="px-4 py-2 text-left">Tahun</th>
                        <th class="px-4 py-2 text-left">Kapasitas Mesin</th>
                        <th class="px-4 py-2 text-left">Transmisi</th>
                        <th class="px-4 py-2 text-left">Bahan Bakar</th>
                        <th class="px-4 py-2 text-left">Periode Produksi</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(car, index) in filteredCars" :key="car.id" class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">{{ car.brand.name }}</td>
                        <td class="px-4 py-2">{{ car.car_model.name }}</td>
                        <td class="px-4 py-2">{{ car.car_type.name }}</td>
                        <td class="px-4 py-2">{{ car.year }}</td>
                        <td class="px-4 py-2">{{ car.engine_capacity.value }}</td>
                        <td class="px-4 py-2">{{ car.transmission.type }}</td>
                        <td class="px-4 py-2">{{ car.fuel_type.name }}</td>
                        <td class="px-4 py-2">{{ car.production_period }}</td>
                        <td class="px-4 py-2 text-center">
                            <SecondaryButton @click="openModal('edit', car)">Edit</SecondaryButton>
                            <PrimaryButton class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(car.id)">Hapus</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Create / Edit -->
        <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Mobil' : 'Tambah Mobil'" @close="closeModal">
            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <InputLabel for="brand_id" value="Brand" />
                        <select id="brand_id" v-model="form.brand_id" class="block w-full border p-2 rounded">
                            <option value="">Pilih Brand / Merek</option>
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>

                        <InputError :message="form.errors.brand_id" />
                    </div>

                    

                    <div class="mb-4">
                        <InputLabel for="car_model_id" value="Model" />
                        <select id="car_model_id" v-model="form.car_model_id" class="block w-full border p-2 rounded">
                            <option value="">Pilih Model</option>
                            <option v-for="model in filteredCarModels" :key="model.id" :value="model.id">
                                {{ model.name }}
                            </option>
                        </select>
                       
                        <InputError :message="form.errors.car_model_id" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="car_type_id" value="Tipe" />
                        <select id="car_type_id" v-model="form.car_type_id" class="block w-full border p-2 rounded">
                             <option value="">Pilih Tipe</option>
                            <option v-for="type in filteredCarTypes" :key="type.id" :value="type.id">
                                {{ type.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.car_type_id" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="year" value="Tahun Pembuatan" />
                        <select id="year" v-model="form.year" class="block w-full border p-2 rounded">
                            <option value="">Pilih Tahun</option>
                            <option v-for="year in years" :key="year" :value="year">
                                {{ year }}
                            </option>
                        </select>
                        <InputError :message="form.errors.year" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="engine_capacity_id" value="Kapasitas Mesin" />
                        <select id="engine_capacity_id" v-model="form.engine_capacity_id" class="block w-full border p-2 rounded">
                            <option value="">Pilih Kapasitas</option>
                            <option v-for="capacity in engineCapacities" :key="capacity.id" :value="capacity.id">
                                {{ capacity.value }}
                            </option>
                        </select>
                        <InputError :message="form.errors.engine_capacity_id" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="transmission_id" value="Transmisi" />
                        <select id="transmission_id" v-model="form.transmission_id" class="block w-full border p-2 rounded">
                            <option value="">Pilih Transmisi</option>
                            <option v-for="transmission in transmissions" :key="transmission.id" :value="transmission.id">
                                {{ transmission.type }}
                            </option>
                        </select>
                        <InputError :message="form.errors.transmission_id" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="fuel_type_id" value="Bahan Bakar" />
                        <select id="fuel_type_id" v-model="form.fuel_type_id" class="block w-full border p-2 rounded">
                           <option value="">Pilih Bahan Bakar</option>
                            <option v-for="fuelType in fuelTypes" :key="fuelType.id" :value="fuelType.id">
                                {{ fuelType.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.fuel_type_id" />
                    </div>

                    <div class="mb-4">
                        <InputLabel value="Periode Produksi" />
                        <div class="flex space-x-4">
                            <select v-model="form.production_period_start" class="block w-full border p-2 rounded">
                               <option value="">Pilih Tahun</option>
                                <option v-for="year in years" :key="year" :value="year">
                                    {{ year }}
                                </option>
                            </select>
                            <select v-model="form.production_period_end" class="block w-full border p-2 rounded">
                               <option value="">Pilih Tahun</option>
                                <option v-for="year in years" :key="year" :value="year">
                                    {{ year }}
                                </option>
                            </select>
                        </div>
                        <InputError :message="form.errors.production_period_start" />
                        <InputError :message="form.errors.production_period_end" />
                    </div>

                    <div class="flex justify-end mt-4">
                        <SecondaryButton type="button" @click="closeModal">Batal</SecondaryButton>
                        <PrimaryButton class="ml-3" type="submit" :disabled="form.processing">
                            {{ isEditMode ? 'Update' : 'Simpan' }}
                        </PrimaryButton>
                    </div>
                </form>
            </template>
        </CustomModal>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from '@/Components/InputError.vue';
import CustomModal from "@/Components/CustomModal.vue";

const props = defineProps({
  cars: Array,
  brands: Array,
  carModels: Array,
  carTypes: Array,
  engineCapacities: Array,
  transmissions: Array,
  fuelTypes: Array,
});

// State untuk filter
const searchQuery = ref("");
const selectedBrand = ref("");
const selectedCarModel = ref("");
const selectedCarType = ref("");

// State untuk modal
const modalOpen = ref(false);
const isEditMode = ref(false);
const selectedId = ref(null);

// Generate tahun dari 1999 sampai sekarang
const currentYear = new Date().getFullYear();
const years = computed(() => {
  const years = [];
  for (let year = 1999; year <= currentYear; year++) {
    years.push(year);
  }
  return years;
});

// Setup form
const form = useForm({
  brand_id: "",
  car_model_id: "",
  car_type_id: "",
  year: "", // Kosongkan tahun saat pertama kali
  engine_capacity_id: "",
  transmission_id: "",
  fuel_type_id: "",
  production_period_start: "", // Kosongkan periode awal
  production_period_end: "", // Kosongkan periode akhir
});

// Filter carModels berdasarkan brand_id yang dipilih di form
const filteredCarModels = computed(() => {
  if (!form.brand_id) return [];
  return props.carModels.filter(model => model.brand_id == form.brand_id);
});

// Filter carTypes berdasarkan car_model_id yang dipilih di form
const filteredCarTypes = computed(() => {
  if (!form.car_model_id) return [];
  return props.carTypes.filter(type => type.car_model_id == form.car_model_id);
});

// Filter data mobil untuk tabel
const filteredCars = computed(() => {
  return props.cars.filter(car => {
    const matchesBrand = selectedBrand.value ? car.brand_id == selectedBrand.value : true;
    const matchesModel = selectedCarModel.value ? car.car_model_id == selectedCarModel.value : true;
    const matchesType = selectedCarType.value ? car.car_type_id == selectedCarType.value : true;
    const matchesSearch = car.car_model?.name?.toLowerCase().includes(searchQuery.value.toLowerCase());
    
    return matchesBrand && matchesModel && matchesType && matchesSearch;
  });
});

// Handle modal
const openModal = (mode, car = null) => {
  isEditMode.value = mode === 'edit';
  modalOpen.value = true;

  if (isEditMode.value && car) {
    selectedId.value = car.id;
    // Split production period
    const [start, end] = car.production_period.split('-');
    
    // Isi form dengan data yang akan di-edit
    form.brand_id = car.brand_id;
    form.car_model_id = car.car_model_id;
    form.car_type_id = car.car_type_id;
    form.year = car.year;
    form.engine_capacity_id = car.engine_capacity_id;
    form.transmission_id = car.transmission_id;
    form.fuel_type_id = car.fuel_type_id;
    form.production_period_start = start;
    form.production_period_end = end;
  } else {
    // Reset form untuk mode tambah
    resetForm();
  }
};

const resetForm = () => {
  form.reset();
  form.year = ""; // Kosongkan tahun
  form.production_period_start = ""; // Kosongkan periode awal
  form.production_period_end = ""; // Kosongkan periode akhir
};

const closeModal = () => {
  modalOpen.value = false;
  resetForm();
};

// Submit form
const submitForm = () => {
  const formData = {
    ...form.data(),
    production_period_start: form.production_period_start,
    production_period_end: form.production_period_end
  };

  if (isEditMode.value) {
    form.put(route('cars.update', selectedId.value), {
      onSuccess: () => {
        closeModal();
        router.reload({ only: ['cars'] });
      },
      onError: (errors) => {
        console.error('Update error:', errors);
      }
    });
  } else {
    form.post(route('cars.store'), {
      onSuccess: () => {
        closeModal();
        router.reload({ only: ['cars'] });
      },
      onError: (errors) => {
        console.error('Create error:', errors);
      }
    });
  }
};

// Handle delete
const confirmDelete = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    router.delete(route('cars.destroy', id), {
      onSuccess: () => router.reload({ only: ['cars'] }),
      onError: (errors) => console.error('Delete error:', errors)
    });
  }
};

// Watch untuk reset car_model_id dan car_type_id saat brand_id berubah
watch(() => form.brand_id, (newBrandId) => {
  form.car_model_id = ""; // Reset car_model_id saat brand berubah
  form.car_type_id = ""; // Reset car_type_id saat brand berubah
});

// Watch untuk reset car_type_id saat car_model_id berubah
watch(() => form.car_model_id, (newCarModelId) => {
  form.car_type_id = ""; // Reset car_type_id saat model berubah
});
</script>