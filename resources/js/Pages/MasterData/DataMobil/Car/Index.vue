<template>
  <div class="p-4">
    <!-- Judul Halaman -->
    <h1 class="text-2xl font-bold mb-4">Data Mobil</h1>

    <!-- Tombol Tambah Data -->
    <div class="mb-4">
      <Link :href="route('cars.create')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        Tambah Data Mobil
      </Link>
    </div>

    <!-- Tabel Data Mobil -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left">Merek</th>
            <th class="px-4 py-2 text-left">Model</th>
            <th class="px-4 py-2 text-left">Tipe</th>
            <th class="px-4 py-2 text-left">Kapasitas Mesin</th>
            <th class="px-4 py-2 text-left">Transmisi</th>
            <th class="px-4 py-2 text-left">Bahan Bakar</th>
            <th class="px-4 py-2 text-left">Periode</th>
            <th class="px-4 py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="car in cars" :key="car.id" class="border-b">
            <td class="px-4 py-2">{{ car.brand.name }}</td>
            <td class="px-4 py-2">{{ car.model.name }}</td>
            <td class="px-4 py-2">{{ car.car_type.name }}</td>
            <td class="px-4 py-2">{{ car.engine_capacity.value }} CC</td>
            <td class="px-4 py-2">{{ car.transmission.type }}</td>
            <td class="px-4 py-2">{{ car.fuel_type.name }}</td>
            <td class="px-4 py-2">{{ car.production_period.start_year }} - {{ car.production_period.end_year }}</td>
            <td class="px-4 py-2">
              <Link :href="route('cars.edit', car.id)" class="text-blue-600 hover:text-blue-800">Edit</Link>
              <button @click="deleteCar(car.id)" class="text-red-600 hover:text-red-800 ml-2">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

// Props untuk menerima data dari controller
defineProps({
  cars: Array,
});

// Fungsi untuk menghapus data mobil
const deleteCar = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    Inertia.delete(route('cars.destroy', id));
  }
};
</script>