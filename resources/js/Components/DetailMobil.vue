<template>
  <div class="bg-white p-4 shadow-md rounded-lg mb-4">
    <h2 class="text-lg font-bold text-gray-700 mb-3">Detail Mobil</h2>

    <!-- Nopol -->
    <div class="mb-3">
      <label class="block text-sm font-medium text-gray-700">Nomor Polisi</label>
      <div class="flex space-x-2">
        <input v-model="formData.nopol1" maxlength="2" class="border px-3 py-2 rounded w-16 text-center uppercase" placeholder="AB" />
        <input v-model="formData.nopol2" maxlength="4" class="border px-3 py-2 rounded w-20 text-center" placeholder="1234" />
        <input v-model="formData.nopol3" maxlength="3" class="border px-3 py-2 rounded w-16 text-center uppercase" placeholder="XYZ" />
      </div>
    </div>

    <!-- Merek -->
    <div class="mb-3">
      <label class="block text-sm font-medium text-gray-700">Merek</label>
      <select v-model="formData.merek" class="border px-3 py-2 rounded w-full">
        <option value="">Pilih Merek</option>
        <option v-for="brand in brands" :key="brand" :value="brand">{{ brand }}</option>
      </select>
    </div>

    <!-- Tahun Pembuatan -->
    <div class="mb-3">
      <label class="block text-sm font-medium text-gray-700">Tahun Pembuatan</label>
      <input v-model="formData.tahun" type="number" class="border px-3 py-2 rounded w-full" placeholder="2020" />
    </div>

    <!-- Model -->
    <div class="mb-3">
      <label class="block text-sm font-medium text-gray-700">Model</label>
      <select v-model="formData.model" class="border px-3 py-2 rounded w-full">
        <option value="">Pilih Model</option>
        <option v-for="model in models" :key="model" :value="model">{{ model }}</option>
      </select>
    </div>

    <!-- Tipe -->
    <div class="mb-3">
      <label class="block text-sm font-medium text-gray-700">Tipe</label>
      <select v-model="formData.tipe" class="border px-3 py-2 rounded w-full">
        <option value="">Pilih Tipe</option>
        <option v-for="tipe in types" :key="tipe" :value="tipe">{{ tipe }}</option>
      </select>
    </div>

    <!-- Transmisi -->
    <div class="mb-3">
      <label class="block text-sm font-medium text-gray-700">Transmisi</label>
      <div class="flex space-x-4">
        <button @click="formData.transmisi = 'AT'"
          :class="formData.transmisi === 'AT' ? 'bg-blue-500 text-white' : 'bg-gray-200'"
          class="px-4 py-2 rounded-lg">AT</button>
        <button @click="formData.transmisi = 'MT'"
          :class="formData.transmisi === 'MT' ? 'bg-blue-500 text-white' : 'bg-gray-200'"
          class="px-4 py-2 rounded-lg">MT</button>
      </div>
    </div>

    <!-- Warna -->
    <div class="mb-3">
      <label class="block text-sm font-medium text-gray-700">Warna</label>
      <input v-model="formData.warna" type="text" class="border px-3 py-2 rounded w-full" placeholder="Hitam, Putih, dll." />
    </div>
  </div>
</template>

<script>
import { ref } from "vue";

export default {
  props: {
    formData: Object
  },
  setup() {
    const brands = ref(["Toyota", "Honda", "Suzuki", "Mitsubishi", "Nissan"]);
    const models = ref(["Avanza", "Civic", "Ertiga", "Pajero", "X-Trail"]);
    const types = ref(["G", "E", "RS", "VRZ", "GR Sport"]);

    return {
      brands,
      models,
      types
    };
  }
};
</script>

<style scoped>
input:focus,
select:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
}
</style>
