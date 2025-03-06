<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';




</script>

<template>
  <SidebarProvider>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
      <!-- Sidebar -->
      <AppSidebar class="bg-white w-64 min-h-screen" />

      
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">

       
        
        <header class="bg-white dark:bg-gray-800 shadow px-6 py-4 flex items-center justify-between w-full">
          <SidebarTrigger class="text-gray-500 dark:text-gray-400" />
          <h1>Welcome to the Admin Branch</h1>

        </header>

        <main class="p-6">
          <p class="text-gray-700">Dashboard Content Goes Here</p>
        </main>
      </div>
    </div>
  </SidebarProvider>
</template>