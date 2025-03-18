<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";

const title = "Account Management";
const searchQuery = ref("");

// User data
const tableData = ref([
  { id: 1, name: "John Doe", branch: "101", password: "********" },
  { id: 2, name: "Jane Smith", branch: "102", password: "********" },
  { id: 3, name: "Alice Johnson", branch: "103", password: "********" }
]);

// Modal visibility states
const isAddUserModalOpen = ref(false);
const isEditUserModalOpen = ref(false);

// Edit user data
const selectedUser = ref({
  id: null,
  name: "",
  branch: "",
  password: ""
});

// Method to open the "Add User" modal
const openAddUserModal = () => {
  isAddUserModalOpen.value = true;
};

// Method to close the "Add User" modal
const closeAddUserModal = () => {
  isAddUserModalOpen.value = false;
};

// Method to open the "Edit User" modal with selected user data
const openEditUserModal = (user: any) => {
  selectedUser.value = { ...user }; // Copy the user data to selectedUser
  isEditUserModalOpen.value = true;
};

// Method to close the "Edit User" modal
const closeEditUserModal = () => {
  isEditUserModalOpen.value = false;
};
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

        <main class="flex-1 p-6 w-full">
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
              <Button variant="outline" @click="openAddUserModal">Add User</Button>
            </div>

            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">ID</TableHead>
                  <TableHead class="px-4 py-2 text-left">Name</TableHead>
                  <TableHead class="px-4 py-2 text-left">Branch</TableHead>
                  <TableHead class="px-4 py-2 text-left">Password</TableHead>
                  <TableHead class="px-4 py-2 text-left">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="user in tableData" :key="user.id" class="border-b">
                  <TableCell class="px-4 py-2">{{ user.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ user.name }}</TableCell>
                  <TableCell class="px-4 py-2">{{ user.branch }}</TableCell>
                  <TableCell class="px-4 py-2">{{ user.password }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button size="sm" variant="outline" @click="openEditUserModal(user)">Edit</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>
        </main>
      </div>
    </div>

    <!-- Add User Modal -->
    <div v-if="isAddUserModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Add User</h2>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Name</label>
          <Input class="w-full" placeholder="Enter name" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Branch</label>
          <Input class="w-full" placeholder="Enter branch" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Password</label>
          <Input class="w-full" placeholder="Enter password" type="password" />
        </div>
        <div class="flex justify-end">
          <Button @click="closeAddUserModal" variant="outline" class="mr-2">Cancel</Button>
          <Button variant="solid">Save</Button>
        </div>
      </div>
    </div>

    <!-- Edit User Modal -->
    <div v-if="isEditUserModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Edit User</h2>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Name</label>
          <Input v-model="selectedUser.name" class="w-full" placeholder="Enter name" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Branch</label>
          <Input v-model="selectedUser.branch" class="w-full" placeholder="Enter branch" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Password</label>
          <Input v-model="selectedUser.password" class="w-full" placeholder="Enter password" type="password" />
        </div>
        <div class="flex justify-end">
          <Button @click="closeEditUserModal" variant="outline" class="mr-2">Cancel</Button>
          <Button variant="solid">Save Changes</Button>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>
