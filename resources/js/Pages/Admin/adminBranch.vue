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

    <!-- Add User Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="text-xl mb-4">Add New User</div>
        <div class="mb-4">
          <Input v-model="newUser.name" placeholder="Name" class="w-full" />
        </div>
        <div class="mb-4">
          <Input v-model="newUser.branch" placeholder="Branch" class="w-full" />
        </div>
        <div class="mb-4">
          <Input v-model="newUser.password" type="password" placeholder="Password" class="w-full" />
        </div>
        <div class="flex justify-end space-x-4">
          <Button @click="closeAddModal" variant="outline">Cancel</Button>
          <Button @click="addUser" variant="primary">Add User</Button>
        </div>
      </div>
    </div>

    <!-- Edit User Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="text-xl mb-4">Edit User</div>
        <div class="mb-4">
          <Input v-model="editUser.name" placeholder="Name" class="w-full" />
        </div>
        <div class="mb-4">
          <Input v-model="editUser.branch" placeholder="Branch" class="w-full" />
        </div>
        <div class="mb-4">
          <Input v-model="editUser.password" type="password" placeholder="Password" class="w-full" />
        </div>
        <div class="flex justify-end space-x-4">
          <Button @click="closeEditModal" variant="outline">Cancel</Button>
          <Button @click="saveEdit" variant="primary">Save</Button>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>