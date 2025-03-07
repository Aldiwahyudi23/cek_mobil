<template>
    <Teleport to="body">
        <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b pb-2">
                    <h2 class="text-lg font-semibold">{{ title }}</h2>
                    <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <div class="mt-4">
                    <slot name="content"></slot>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
defineProps({
    show: Boolean,
    title: String,
});
</script>
