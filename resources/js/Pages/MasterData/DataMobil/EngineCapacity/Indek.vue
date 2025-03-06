<template>
    <div class="p-4">
        <div class="flex justify-between items-center">
            <PrimaryButton @click="openModal('create')">Tambah Kapasitas</PrimaryButton>
            <input
                v-model="search"
                type="text"
                placeholder="Cari Kapasitas..."
                class="border px-3 py-2 rounded-md shadow-sm w-64"
            />
        </div>

        <div class="mt-4 overflow-x-auto">
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

        <CustomModal :show="modalOpen" :title="isEditMode ? 'Edit Kapasitas' : 'Tambah Kapasitas'" @close="closeModal">
            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <InputLabel for="value" value="Kapasitas (CC)" />
                        <TextInput id="value" v-model="form.value" type="number" class="block w-full" required />
                        <InputError :message="form.errors.value" />
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
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import CustomModal from '@/Components/CustomModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const capacities = ref([...usePage().props.capacities]);
const modalOpen = ref(false);
const isEditMode = ref(false);
const search = ref('');

const form = useForm({
    id: '',
    value: '',
});

const filteredCapacities = computed(() => {
    return capacities.value.filter(c => c.value.toString().includes(search.value));
});

const openModal = (mode, item = null) => {
    isEditMode.value = mode === 'edit';
    if (isEditMode.value && item) {
        form.id = item.id;
        form.value = item.value;
    } else {
        form.reset();
    }
    modalOpen.value = true;
};

const closeModal = () => {
    form.reset();
    modalOpen.value = false;
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('capacity.update', form.id), {
            onSuccess: () => {
                const index = capacities.value.findIndex(c => c.id === form.id);
                if (index !== -1) {
                    capacities.value[index] = { ...form.data() };
                }
                closeModal();
            }
        });
    } else {
        form.post(route('capacity.store'), {
            onSuccess: (response) => {
                capacities.value.unshift(response.props.capacities[0]);
                closeModal();
            }
        });
    }
};

const confirmDelete = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus kapasitas ini?')) {
        form.delete(route('capacity.destroy', id), {
            onSuccess: () => {
                capacities.value = capacities.value.filter(c => c.id !== id);
            }
        });
    }
};
</script>
