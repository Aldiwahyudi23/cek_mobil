<template>
    <div class="p-4">
        <!-- Tombol Tambah Data -->
        <PrimaryButton @click="openModal('create')">Tambah Kategori</PrimaryButton>

        <!-- Tabel Data -->
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full border bg-white rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Deskripsi</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in categories" :key="item.id" class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">{{ item.name }}</td>
                        <td class="px-4 py-2">{{ item.description || '-' }}</td>
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
        <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Kategori' : 'Tambah Kategori'" @close="closeModal">
            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <InputLabel for="name" value="Nama Kategori" />
                        <TextInput id="name" v-model="form.name" class="block w-full" required />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="description" value="Deskripsi" />
                        <TextInput id="description" v-model="form.description" class="block w-full" />
                        <InputError :message="form.errors.description" />
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

<script setup>
import { ref, reactive } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

// State untuk kategori (dapat diperbarui langsung)
const categories = reactive([...usePage().props.categories]);
const modalOpen = ref(false);
const isEditMode = ref(false);

// Form default (di-reset setiap kali modal dibuka)
const defaultForm = {
    id: '',
    name: '',
    description: '',
    is_active: false,
};

// Menggunakan form reaktif
const form = useForm({ ...defaultForm });

const openModal = (mode, item = null) => {
    isEditMode.value = mode === 'edit';
    
    if (isEditMode.value && item) {
        // Pastikan `is_active` benar-benar boolean (bukan null atau string)
        form.id = item.id;
        form.name = item.name;
        form.description = item.description;
        form.is_active = Boolean(item.is_active);
    } else {
        form.reset(); // Reset data form ketika membuka modal Create
    }
    
    modalOpen.value = true;
};

const closeModal = () => {
    form.reset(); // Reset form saat modal ditutup
    modalOpen.value = false;
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('categories.update', form.id), {
            onSuccess: () => {
                // Perbarui kategori dalam state tanpa reload
                const index = categories.findIndex((c) => c.id === form.id);
                if (index !== -1) {
                    categories[index] = { ...form.data() };
                }
                closeModal();
            }
        });
    } else {
        form.post(route('categories.store'), {
            onSuccess: (response) => {
                // Tambahkan kategori baru ke daftar tanpa reload
                categories.unshift(response.props.categories[0]);
                closeModal();
            }
        });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        form.delete(route('categories.destroy', id), {
            onSuccess: () => {
                // Hapus dari daftar tanpa reload
                const index = categories.findIndex((c) => c.id === id);
                if (index !== -1) {
                    categories.splice(index, 1);
                }
            }
        });
    }
};
</script>
