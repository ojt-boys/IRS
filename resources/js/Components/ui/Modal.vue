<script setup>
defineProps({
  show: Boolean, // Control modal visibility
});
defineEmits(["close"]);
</script>

<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Add User</h2>
        <button @click="$emit('close')" class="text-gray-600 hover:text-gray-800">✖</button>
      </div>

      <slot></slot> <!-- Slot to insert form content -->
    </div>
  </div>
</template>
