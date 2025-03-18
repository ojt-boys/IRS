<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';




</script>



<template>
  <SidebarProvider>
    <div class="flex min-h-screen w-full bg-gray-100 dark:bg-gray-900">
      <AppSidebar class="shrink-0" />
      <div class="flex flex-col flex-1 w-full">
        <Head :title="title" />
        <header class="bg-white dark:bg-gray-800 shadow px-6 h-20 flex items-center justify-center relative">
          <SidebarTrigger class="text-gray-500 dark:text-gray-400 absolute left-6" />
          <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 w-full text-center">
            {{ title }}
          </div>
        </header>

        <main class="p-6">
          <p class="text-gray-700">Dashboard Content Goes Here</p>
        </main>
      </div>
    </div>

    <!-- Modal for Service Warranty -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96">
        <div class="text-xl font-semibold mb-4">Service Warranty</div>
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2">Service</label>
          <Input v-model="warrantyService" placeholder="Enter service type" />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2">Shoe Code</label>
          <Input v-model="warrantyShoeCode" placeholder="Enter shoe code" />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium mb-2">Branch</label>
          <Input v-model="warrantyBranch" placeholder="Enter branch number" />
        </div>
        <div class="flex justify-end space-x-2">
          <Button variant="outline" @click="closeModal">Cancel</Button>
          <Button variant="solid" @click="submitWarranty">Submit</Button>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>