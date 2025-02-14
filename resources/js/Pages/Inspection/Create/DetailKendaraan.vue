<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";

const form = useForm({
    nopol: "",
    merek: "",
    tahun: "",
    model: "",
    type: "",
    cc: "",
    transmition: "AT",
    bahan_bakar: "",
    periode: "",
    warna: "",
});

// Submit form
const submitForm = () => {
    form.post(route("request-inspection.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold text-center mb-4">Request Pengecekan Kendaraan</h2>

            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <InputLabel for="nopol" value="Nomor Polisi" />
                    <TextInput id="nopol" v-model="form.nopol" class="w-full uppercase" required />
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <InputLabel for="merek" value="Merek" />
                        <TextInput id="merek" v-model="form.merek" class="w-full" required />
                    </div>
                    <div>
                        <InputLabel for="tahun" value="Tahun" />
                        <TextInput id="tahun" v-model="form.tahun" type="number" class="w-full" required />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <InputLabel for="model" value="Model" />
                        <TextInput id="model" v-model="form.model" class="w-full" required />
                    </div>
                    <div>
                        <InputLabel for="type" value="Type" />
                        <TextInput id="type" v-model="form.type" class="w-full" required />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <InputLabel for="cc" value="Kapasitas CC" />
                        <TextInput id="cc" v-model="form.cc" type="number" class="w-full" required />
                    </div>
                    <div>
                        <InputLabel for="bahan_bakar" value="Bahan Bakar" />
                       <SelectInput
  id="bahan_bakar"
  name="bahan_bakar"
  v-model="form.bahan_bakar"
  label="Bahan Bakar"
  placeholder="Pilih Bahan Bakar"
  :error="errors.bahan_bakar"
>
  <option value="Bensin">Bensin</option>
  <option value="Diesel">Diesel</option>
  <option value="Listrik">Listrik</option>
  <option value="Listrik">HyBird</option>
</SelectInput>
                    </div>
                </div>

                <div class="mb-4">
                    <InputLabel for="transmition" value="Transmisi" />
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" v-model="form.transmition" value="AT" class="mr-2" />
                            AT (Automatic)
                        </label>
                        <label class="flex items-center">
                            <input type="radio" v-model="form.transmition" value="MT" class="mr-2" />
                            MT (Manual)
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <InputLabel for="periode" value="Periode Model" />
                        <TextInput id="periode" v-model="form.periode" class="w-full" required />
                    </div>
                    <div>
                        <InputLabel for="warna" value="Warna" />
                        <TextInput id="warna" v-model="form.warna" class="w-full uppercase" required />
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <SecondaryButton type="button" @click="form.reset()">Reset</SecondaryButton>
                    <PrimaryButton type="submit" :disabled="form.processing">Kirim</PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
