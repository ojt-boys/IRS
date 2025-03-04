<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';

defineProps({
  title: String,
});

const logout = () => {
  router.post(route('logout'));
};
</script>

<template>
  <SidebarProvider>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
      <!-- Sidebar -->
      <AppSidebar />
      
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">
        <Head :title="title" />
        
        <header class="bg-white dark:bg-gray-800 shadow px-6 py-4 flex items-center justify-between w-full">
          <SidebarTrigger class="text-gray-500 dark:text-gray-400" />
          <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
            {{ title }}
          </div>
          <button @click="logout" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
            Log Out
          </button>
        </header>

        <main class="p-6">
          <slot />
        </main>
      </div>
    </div>
  </SidebarProvider>
</template>