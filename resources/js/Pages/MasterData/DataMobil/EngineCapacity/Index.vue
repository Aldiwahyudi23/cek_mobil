<template>
    <div class="p-4">
        <!-- Bagian Header: Tombol Tambah & Pencarian -->
        <div class="flex justify-between items-center mb-4">
            <PrimaryButton @click="openModal('create')">Tambah Kapasitas</PrimaryButton>
            <div class="relative">
                <TextInput 
                    v-model="searchQuery" 
                    placeholder="Cari Kapasitas..." 
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
                        <th class="px-4 py-2 text-left">Kapasitas (CC)</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredCapacities" :key="item.id" class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">{{ item.value }}</td>
                        <td class="px-4 py-2 text-center">
                            <SecondaryButton @click="openModal('edit', item)">Edit</SecondaryButton>
                            <PrimaryButton class="ml-2 bg-red-600 hover:bg-red-700" @click="confirmDelete(item.id)">Hapus</PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Create / Edit -->
        <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Kapasitas' : 'Tambah Kapasitas'" @close="closeModal">
            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <InputLabel for="value" value="Kapasitas (CC)" />
                        <TextInput id="value" v-model.number="form.value" type="number" class="block w-full" required />
                        <InputError :message="form.errors.value" />
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
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import CustomModal from "@/Components/CustomModal.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    capacities: Array, // Data kapasitas dari server
});

// State untuk modal
const modalOpen = ref(false);
const isEditMode = ref(false);
const selectedId = ref(null);

// Form CRUD
const form = useForm({
    value: "",
});

// Pencarian
const searchQuery = ref("");

// Filter data berdasarkan pencarian
const filteredCapacities = computed(() => {
    return props.capacities.filter((item) => {
        return item.value.toString().includes(searchQuery.value);
    });
});

// Fungsi membuka modal (Tambah/Edit)
const openModal = (mode, item = null) => {
    isEditMode.value = mode === "edit";
    modalOpen.value = true;

    if (isEditMode.value && item) {
        selectedId.value = item.id;
        form.value = item.value;
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

// Fungsi untuk submit form
const submitForm = () => {
    if (isEditMode.value) {
        form.put(route("capacity.update", selectedId.value), {
            onSuccess: () => {
                closeModal();
                // Refresh data setelah update
                router.reload({ only: ['capacities'] });
            },
            onError: (errors) => {
                console.error("Error saat update:", errors);
            },
        });
    } else {
        form.post(route("capacity.store"), {
            onSuccess: () => {
                closeModal();
                // Refresh data setelah tambah
                router.reload({ only: ['capacities'] });
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
        router.delete(route("capacity.destroy", id), {
            onSuccess: () => {
                // Refresh data setelah hapus
                router.reload({ only: ['capacities'] });
            },
            onError: (errors) => {
                console.error("Error saat hapus:", errors);
            },
        });
    }
};
</script>