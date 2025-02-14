<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import CustomModal from "@/Components/CustomModal.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    inspectionPoints: Array,
    categories: Array,
});

// State untuk modal
const modalOpen = ref(false);
const isEditMode = ref(false);
const selectedId = ref(null);

// Form CRUD
const form = useForm({
    categories_id: "",
    name: "",
    description: "",
    type_input: "",
    is_active: true,
});

// Filter & Pencarian
const selectedCategory = ref("");
const searchQuery = ref("");

// Filter data berdasarkan kategori dan pencarian
const filteredInspectionPoints = computed(() => {
    return props.inspectionPoints.filter((item) => {
        const matchCategory = selectedCategory.value ? item.categories_id === selectedCategory.value : true;
        const matchSearch = item.name.toLowerCase().includes(searchQuery.value.toLowerCase());
        return matchCategory && matchSearch;
    });
});

// Fungsi membuka modal (Tambah/Edit)
const openModal = (mode, item = null) => {
    isEditMode.value = mode === "edit";
    modalOpen.value = true;

    if (isEditMode.value && item) {
        selectedId.value = item.id;
        form.categories_id = item.categories_id;
        form.name = item.name;
        form.description = item.description;
        form.type_input = item.type_input;
        form.is_active = Boolean(item.is_active);
    } else {
        resetForm();
    }
};

// Reset form setelah simpan/tambah baru
const resetForm = () => {
    form.categories_id = "";
    form.name = "";
    form.description = "";
    form.type_input = "";
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
        form.put(route("inspection-points.update", selectedId.value), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route("inspection-points.store"), {
            onSuccess: () => closeModal(),
        });
    }
};

// Fungsi menghapus data
const confirmDelete = (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        router.delete(route("inspection-points.destroy", id));
    }
};
</script>

<template>
    <div class="p-4">
        <!-- Tombol Tambah Data -->
        <div class="flex justify-between items-center mb-4">
            <PrimaryButton @click="openModal('create')">Tambah Inspection Point</PrimaryButton>

            <!-- Filter & Search -->
            <div class="flex space-x-4">
                <!-- Filter Kategori -->
                <select v-model="selectedCategory" class="border rounded px-7 py-2">
                    <option value="">Semua Kategori</option>
                    <option v-for="category in props.categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>

                <!-- Kolom Pencarian -->
                <TextInput v-model="searchQuery" placeholder="Cari Inspection Point..." />
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
                        <!-- <th class="px-4 py-2 text-left">Deskripsi</th> -->
                        <th class="px-4 py-2 text-left">Tipe Input</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredInspectionPoints" :key="item.id" class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">{{ item.category.name }}</td>
                        <td class="px-4 py-2">{{ item.name }}</td>
                        <!-- <td class="px-4 py-2">{{ item.description || '-' }}</td> -->
                        <td class="px-4 py-2">{{ item.type_input }}</td>
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
        <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Inspection Point' : 'Tambah Inspection Point'" @close="closeModal">
            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <InputLabel for="categories_id" value="Kategori" />
                        <select id="categories_id" v-model="form.categories_id" class="block w-full border p-2 rounded">
                            <option v-for="category in props.categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <InputLabel for="name" value="Nama Inspection" />
                        <TextInput id="name" v-model="form.name" class="block w-full" required />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="description" value="Deskripsi" />
                        <TextInput id="description" v-model="form.description" class="block w-full" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="type_input" value="Tipe Input" />
                        <select id="type_input" v-model="form.type_input" class="block w-full border p-2 rounded" required>
                            <option value="">--Pilih Tipe Input--</option>
                            <option value="Input Text">Input Text</option>
                            <option value="Input Number">Input Number</option>
                            <option value="Input Account">Input Account</option>
                            <option value="Tanggal">Tanggal</option>
                            <option value="Foto">Foto</option>
                            <option value="Set">Set</option>
                            <option value="Damage">Damage</option>
                            <option value="Select">Select</option>
                            <option value="Option">Option</option>
                            <option value="Sop">SOP</option>
                            <option value="Option to Foto">Option to Foto</option>
                        </select>
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
