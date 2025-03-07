<template>
    <div class="p-4">
        <!-- Bagian Header: Tombol Tambah & Pencarian -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
            <PrimaryButton @click="openModal('create')">Tambah Transmisi</PrimaryButton>
            <div class="relative">
                <TextInput 
                    v-model="searchQuery" 
                    placeholder="Cari Transmisi..." 
                    class="pl-10 pr-4 py-2 border rounded-md w-64"
                />
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A8.5 8.5 0 1010.5 19a8.5 8.5 0 006.15-2.85z" />
                </svg>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="min-w-full border bg-white rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Tipe Transmisi</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredTransmissions" :key="item.id" class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">{{ item.type }}</td>
                        <td class="px-4 py-2 text-center">
                            <SecondaryButton @click="openModal('edit', item)">Edit</SecondaryButton>
                            <PrimaryButton class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Create / Edit -->
        <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Transmisi' : 'Tambah Transmisi'" @close="closeModal">
            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <InputLabel for="type" value="Tipe Transmisi" />
                        <TextInput id="type" v-model="form.type" type="text" class="block w-full" />
                        <InputError :message="form.errors.type" />
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
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from '@/Components/InputError.vue';
import CustomModal from "@/Components/CustomModal.vue";

// Props dari controller
const props = defineProps({
    transmissions: Array, // Data transmisi dari server
});

// State untuk modal
const modalOpen = ref(false);
const isEditMode = ref(false);
const selectedId = ref(null);

// Form CRUD
const form = useForm({
    type: "",
});

// Pencarian
const searchQuery = ref("");

// Filter data berdasarkan pencarian
const filteredTransmissions = computed(() => {
    return props.transmissions.filter((item) => {
        return item.type.toLowerCase().includes(searchQuery.value.toLowerCase());
    });
});

// Fungsi membuka modal (Tambah/Edit)
const openModal = (mode, item = null) => {
    isEditMode.value = mode === "edit";
    modalOpen.value = true;

    if (isEditMode.value && item) {
        selectedId.value = item.id;
        form.type = item.type; // Isi form dengan data yang akan di-edit
    } else {
        resetForm();
    }
};

// Reset form setelah simpan/tambah baru
const resetForm = () => {
    form.reset();
};

// Menutup modal
const closeModal = () => {
    modalOpen.value = false;
    resetForm();
};

// Fungsi untuk submit form (Create/Update)
const submitForm = () => {
    if (isEditMode.value) {
        // Update data
        form.put(route("transmission.update", selectedId.value), {
            onSuccess: () => {
                closeModal();
                router.reload({ only: ['transmissions'] }); // Refresh data
            },
            onError: (errors) => {
                console.error("Error saat update:", errors);
            },
        });
    } else {
        // Tambah data baru
        form.post(route("transmission.store"), {
            onSuccess: () => {
                closeModal();
                router.reload({ only: ['transmissions'] }); // Refresh data
            },
            onError: (errors) => {
                console.error("Error saat tambah:", errors);
            },
        });
    }
};

// Fungsi menghapus data
const confirmDelete = (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        router.delete(route("transmission.destroy", id), {
            onSuccess: () => {
                router.reload({ only: ['transmissions'] }); // Refresh data
            },
            onError: (errors) => {
                console.error("Error saat hapus:", errors);
            },
        });
    }
};
</script>