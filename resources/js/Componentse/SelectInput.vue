<template>
  <div class="w-full">
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700">
      {{ label }}
    </label>
    <select
      :id="id"
      :name="name"
      v-model="modelValue"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      :class="{ 'border-red-500': error }"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option value="" disabled selected v-if="placeholder">{{ placeholder }}</option>
      <slot></slot>
    </select>
    <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: String,
    label: String,
    id: String,
    name: String,
    placeholder: String,
    error: String
  }
};
</script>
