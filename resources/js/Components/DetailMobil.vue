<template>
  <div>
    <!-- Form Input Detail Mobil -->
    <div class="space-y-4">
      <!-- Nopol -->
      <div>
        <label class="block text-sm font-medium">Nomor Polisi</label>
        <input type="text" v-model="formData.nopol" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan nomor polisi" />
      </div>

      <!-- Merek -->
      <div>
        <label class="block text-sm font-medium">Merek Mobil</label>
        <input type="text" v-model="formData.merek" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan merek mobil" />
      </div>

      <!-- Tahun -->
      <div>
        <label class="block text-sm font-medium">Tahun Mobil</label>
        <input type="number" v-model="formData.tahun" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan tahun mobil" />
      </div>

      <!-- Model -->
      <div>
        <label class="block text-sm font-medium">Model Mobil</label>
        <input type="text" v-model="formData.model" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan model mobil" />
      </div>

      <!-- Type -->
      <div>
        <label class="block text-sm font-medium">Tipe Mobil</label>
        <input type="text" v-model="formData.type" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan tipe mobil" />
      </div>

      <!-- CC -->
      <div>
        <label class="block text-sm font-medium">Kapasitas Mesin (CC)</label>
        <input type="number" v-model="formData.cc" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan kapasitas mesin" />
      </div>

      <!-- Transmisi -->
      <div>
        <label class="block text-sm font-medium">Transmisi</label>
        <select v-model="formData.transmition" 
          class="w-full border px-3 py-2 rounded-lg mt-1">
          <option value="AT">Automatic (AT)</option>
          <option value="MT">Manual (MT)</option>
        </select>
      </div>

      <!-- Bahan Bakar -->
      <div>
        <label class="block text-sm font-medium">Bahan Bakar</label>
        <input type="text" v-model="formData.bahan_bakar" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan bahan bakar" />
      </div>

      <!-- Periode -->
      <div>
        <label class="block text-sm font-medium">Periode</label>
        <input type="text" v-model="formData.periode" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan periode" />
      </div>

      <!-- Warna -->
      <div>
        <label class="block text-sm font-medium">Warna Mobil</label>
        <input type="text" v-model="formData.warna" 
          class="w-full border px-3 py-2 rounded-lg mt-1" 
          placeholder="Masukkan warna mobil" />
      </div>

      <!-- File Upload -->
      <div>
        <label class="block text-sm font-medium">Upload File</label>
        <input type="file" @change="handleFileUpload" 
          class="w-full border px-3 py-2 rounded-lg mt-1" />
      </div>
    </div>

    <!-- Tombol Submit -->
    <div class="mt-6">
      <button @click="submitForm" 
        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
        Lanjut
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    formData: {
      type: Object,
      required: true
    }
  },
  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.formData.file = file;
      }
    },
    submitForm() {
      // Validasi form
      if (!this.formData.nopol || !this.formData.merek || !this.formData.tahun || 
          !this.formData.model || !this.formData.type || !this.formData.cc || 
          !this.formData.transmition || !this.formData.bahan_bakar || 
          !this.formData.periode || !this.formData.warna) {
        alert("Semua data detail mobil harus diisi!");
        return;
      }

      // Emit event untuk submit data
      this.$emit('submit', this.formData);
    }
  }
};
</script>