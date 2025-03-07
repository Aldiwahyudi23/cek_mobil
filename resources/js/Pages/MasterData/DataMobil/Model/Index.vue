<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from '@/Components/InputError.vue';
import CustomModal from "@/Components/CustomModal.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    CarModel: Array,
    brand: Array,
});

// State untuk modal
const modalOpen = ref(false);
const isEditMode = ref(false);
const selectedId = ref(null);

// Form CRUD
const form = useForm({
    brand_id: "",
    name: "",
    is_active: true,
});

// Filter & Pencarian
const selectedBrand = ref("");
const searchQuery = ref("");

// Filter data berdasarkan kategori dan pencarian
const filteredCarModel = computed(() => {
    return props.CarModel.filter((item) => {
        const matchBrand = selectedBrand.value ? item.brand_id === selectedBrand.value : true;
        const matchSearch = item.name.toLowerCase().includes(searchQuery.value.toLowerCase());
        return matchBrand && matchSearch;
    });
});

// Fungsi membuka modal (Tambah/Edit)
const openModal = (mode, item = null) => {
    isEditMode.value = mode === "edit";
    modalOpen.value = true;

    if (isEditMode.value && item) {
        selectedId.value = item.id;
        form.brand_id = item.brand_id;
        form.name = item.name;
        form.is_active = Boolean(item.is_active);
    } else {
        resetForm();
    }
};

// Reset form setelah simpan/tambah baru
const resetForm = () => {
    form.brand_id = "";
    form.name = "";
    form.is_active = true;
};

// Menutup modal
const closeModal = () => {
    modalOpen.value = false;
    resetForm();
};

// Fungsi untuk submit form
const submitForm = () => {
    if (isEditMode.value) {
        form.put(route("model.update", selectedId.value), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route("model.store"), {
            onSuccess: () => closeModal(),
        });
    }
};

// Fungsi menghapus data
const confirmDelete = (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        router.delete(route("model.destroy", id));
    }
};
</script>

<template>
    <div class="p-4">
        <!-- Tombol Tambah Data -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
            <PrimaryButton @click="openModal('create')">Tambah Model</PrimaryButton>

            <!-- Filter & Search -->
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                <!-- Filter Kategori -->
                <select v-model="selectedBrand" class="border rounded px-4 py-2 w-full md:w-48">
                    <option value="">Semua Merek</option>
                    <option v-for="brand in props.brand" :key="brand.id" :value="brand.id">
                        {{ brand.name }}
                    </option>
                </select>

                <!-- Kolom Pencarian -->
                 <div class="relative">
                     <TextInput v-model="searchQuery" placeholder="Cari Model..." class="w-full md:w-48 pl-10 pr-4 py-2 border" />
                      <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
                     </svg>
                 </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="min-w-full border bg-white rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Kategori</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredCarModel" :key="item.id" class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">{{ item.brand.name }}</td>
                        <td class="px-4 py-2">{{ item.name }}</td>
                        <td class="px-4 py-2 text-center">
                            <span v-if="item.is_active" class="px-2 py-1 text-green-700 bg-green-200 rounded-full text-sm">Aktif</span>
                            <span v-else class="px-2 py-1 text-red-700 bg-red-200 rounded-full text-sm">Tidak Aktif</span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <SecondaryButton @click="openModal('edit', item)">Edit</SecondaryButton>
                            <PrimaryButton class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Create / Edit -->
        <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Model' : 'Tambah Model'" @close="closeModal">
            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <InputLabel for="brand_id" value="Merek" />
                        <select id="brand_id" v-model="form.brand_id" class="block w-full border p-2 rounded">
                            <option v-for="brand in props.brand" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.brand_id" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="name" value="Nama Model" />
                        <TextInput id="name" v-model="form.name" class="block w-full" />
                         <InputError :message="form.errors.name" />
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" v-model="form.is_active" class="mr-2" />
                        <label for="is_active">Aktif</label>
                    </div>

                    <div class="flex justify-end mt-4">
                        <SecondaryButton type="button" @click="closeModal">Batal</SecondaryButton>
                        <PrimaryButton class="ml-3" type="submit">{{ isEditMode ? 'Update' : 'Simpan' }}</PrimaryButton>
                    </div>
                </form>
            </template>
        </CustomModal>
    </div>
</template>