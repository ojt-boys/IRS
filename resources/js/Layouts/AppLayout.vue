<script setup>
import Sidebar from '@/Components/sidebar.vue';


</script>
<template>
  <div class="flex">
    <Sidebar />
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>