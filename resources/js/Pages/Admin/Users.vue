<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";

const title = "Users";
const searchQuery = ref("");

// User data
const tableData = ref([
  { id: 1, name: "John Doe", branch: "101", password: "********" },
  { id: 2, name: "Jane Smith", branch: "102", password: "********" },
  { id: 3, name: "Alice Johnson", branch: "103", password: "********" }
]);

// Shoe Tech data
const shoeTechData = ref([
  { id: 1, name: "Tech A", password: "********", description: "High performance tech" },
  { id: 2, name: "Tech B", password: "********", description: "Reliable and durable" }
]);

// Customer data
const customerData = ref([
  { id: 1, name: "Customer A", email: "a@example.com", phone: "123-456-7890" },
  { id: 2, name: "Customer B", email: "b@example.com", phone: "987-654-3210" }
]);

// Modal visibility states for Users, Shoe Tech, and Customers
const isAddUserModalOpen = ref(false);
const isEditUserModalOpen = ref(false);
const isAddShoeTechModalOpen = ref(false);
const isEditShoeTechModalOpen = ref(false);
const isEditCustomerModalOpen = ref(false);

// Modal data
const selectedUser = ref({ id: null, name: "", branch: "", password: "" });
const selectedShoeTech = ref({ id: null, name: "", model: "", description: "" });
const selectedCustomer = ref({ id: null, name: "", email: "", phone: "" });

// Open and close modals
const openAddUserModal = () => isAddUserModalOpen.value = true;
const closeAddUserModal = () => isAddUserModalOpen.value = false;
const openEditUserModal = (user: any) => {
  selectedUser.value = { ...user };
  isEditUserModalOpen.value = true;
};
const closeEditUserModal = () => isEditUserModalOpen.value = false;

const openAddShoeTechModal = () => isAddShoeTechModalOpen.value = true;
const closeAddShoeTechModal = () => isAddShoeTechModalOpen.value = false;
const openEditShoeTechModal = (tech: any) => {
  selectedShoeTech.value = { ...tech };
  isEditShoeTechModalOpen.value = true;
};
const closeEditShoeTechModal = () => isEditShoeTechModalOpen.value = false;


const openEditCustomerModal = (customer: any) => {
  selectedCustomer.value = { ...customer };
  isEditCustomerModalOpen.value = true;
};
const closeEditCustomerModal = () => isEditCustomerModalOpen.value = false;
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
          <!-- User Table -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
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

          <!-- Shoe Tech Table -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
              <Button variant="outline" @click="openAddShoeTechModal">Add Shoe Tech</Button>
            </div>
            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">ID</TableHead>
                  <TableHead class="px-4 py-2 text-left">Name</TableHead>
                  <TableHead class="px-4 py-2 text-left">Password</TableHead>
                  <TableHead class="px-4 py-2 text-left">Description</TableHead>
                  <TableHead class="px-4 py-2 text-left">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="tech in shoeTechData" :key="tech.id" class="border-b">
                  <TableCell class="px-4 py-2">{{ tech.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ tech.name }}</TableCell>
                  <TableCell class="px-4 py-2">{{ tech.password }}</TableCell>
                  <TableCell class="px-4 py-2">{{ tech.description }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button size="sm" variant="outline" @click="openEditShoeTechModal(tech)">Edit</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>

          <!-- Customer Table -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
            </div>
            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">ID</TableHead>
                  <TableHead class="px-4 py-2 text-left">Name</TableHead>
                  <TableHead class="px-4 py-2 text-left">Email</TableHead>
                  <TableHead class="px-4 py-2 text-left">Phone</TableHead>
                  <TableHead class="px-4 py-2 text-left">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="customer in customerData" :key="customer.id" class="border-b">
                  <TableCell class="px-4 py-2">{{ customer.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ customer.name }}</TableCell>
                  <TableCell class="px-4 py-2">{{ customer.email }}</TableCell>
                  <TableCell class="px-4 py-2">{{ customer.phone }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button size="sm" variant="outline" @click="openEditCustomerModal(customer)">Edit</Button>
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

    <!-- Add Shoe Tech Modal -->
    <div v-if="isAddShoeTechModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Add Shoe Tech</h2>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Name</label>
          <Input class="w-full" placeholder="Enter tech name" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Password</label>
          <Input class="w-full" placeholder="Enter tech password" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Description</label>
          <Input class="w-full" placeholder="Enter tech description" />
        </div>
        <div class="flex justify-end">
          <Button @click="closeAddShoeTechModal" variant="outline" class="mr-2">Cancel</Button>
          <Button variant="solid">Save</Button>
        </div>
      </div>
    </div>

    <!-- Edit Shoe Tech Modal -->
    <div v-if="isEditShoeTechModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Edit Shoe Tech</h2>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Name</label>
          <Input v-model="selectedShoeTech.name" class="w-full" placeholder="Enter tech name" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Password</label>
          <Input class="w-full" placeholder="Enter tech password" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Description</label>
          <Input v-model="selectedShoeTech.description" class="w-full" placeholder="Enter tech description" />
        </div>
        <div class="flex justify-end">
          <Button @click="closeEditShoeTechModal" variant="outline" class="mr-2">Cancel</Button>
          <Button variant="solid">Save Changes</Button>
        </div>
      </div>
    </div>

    
    <!-- Edit Customer Modal -->
    <div v-if="isEditCustomerModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Edit Customer</h2>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Name</label>
          <Input v-model="selectedCustomer.name" class="w-full" placeholder="Enter customer name" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Email</label>
          <Input v-model="selectedCustomer.email" class="w-full" placeholder="Enter customer email" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-600 dark:text-gray-300">Phone</label>
          <Input v-model="selectedCustomer.phone" class="w-full" placeholder="Enter customer phone" />
        </div>
        <div class="flex justify-end">
          <Button @click="closeEditCustomerModal" variant="outline" class="mr-2">Cancel</Button>
          <Button variant="solid">Save Changes</Button>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>
