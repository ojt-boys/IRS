<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";

// Title for the page
const title = "Account Management";

// Table data for users
const tableData = ref([
  { id: 1, name: "John Doe", branch: "101", password: "********" },
  { id: 2, name: "Jane Smith", branch: "102", password: "********" },
  { id: 3, name: "Alice Johnson", branch: "103", password: "********" }
]);

// Search query for user search
const searchQuery = ref("");

// Modal visibility and form data for adding and editing users
const showAddModal = ref(false);
const showEditModal = ref(false);
const newUser = ref({
  name: "",
  branch: "",
  password: ""
});
const editUser = ref<any>(null); // For editing the selected user

// Show the "Add User" modal
const openAddModal = () => {
  showAddModal.value = true;
};

// Close the "Add User" modal
const closeAddModal = () => {
  showAddModal.value = false;
};

// Show the "Edit User" modal and prefill the form with the selected user's data
const openEditModal = (user: any) => {
  editUser.value = { ...user }; // Clone the user to avoid modifying original directly
  showEditModal.value = true;
};

// Close the "Edit User" modal
const closeEditModal = () => {
  showEditModal.value = false;
};

// Handle adding the new user
const addUser = () => {
  const newId = tableData.value.length + 1;
  tableData.value.push({ ...newUser.value, id: newId, password: "********" });
  closeAddModal();
  newUser.value = { name: "", branch: "", password: "" };
};

// Handle saving the edited user data
const saveEdit = () => {
  const index = tableData.value.findIndex((user) => user.id === editUser.value.id);
  if (index !== -1) {
    tableData.value[index] = { ...editUser.value };
  }
  closeEditModal();
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
              <Button variant="outline" @click="openAddModal">Add User</Button>
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
                    <Button size="sm" variant="outline" @click="openEditModal(user)">Edit</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>
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

