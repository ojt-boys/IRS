<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";

// Modal state and new shoe details
const modalOpen = ref(false);
const newShoe = ref({
  shoeId: '',
  branchNo: '',
  service: '',
  payment: ''
});

const title = "Branch Add Shoes";

// Sample table data
const tableData = ref([
  { id: 1, branch: "101", status: "Incoming", service: "Repair", payment: "Pending" },
  { id: 2, branch: "203", status: "For Checking", service: "Customization", payment: "Paid" },
  { id: 3, branch: "305", status: "Completed", service: "Cleaning", payment: "Paid" },
]);

const searchQuery = ref("");
const sortKey = ref("");
const sortOrder = ref(1);

const filteredTableData = computed(() => {
  let filtered = tableData.value.filter((item) =>
    Object.values(item).some((val) => String(val).toLowerCase().includes(searchQuery.value.toLowerCase()))
  );

  if (sortKey.value) {
    filtered.sort((a, b) => {
      const aValue = a[sortKey.value];
      const bValue = b[sortKey.value];
      return (aValue > bValue ? 1 : -1) * sortOrder.value;
    });
  }

  return filtered;
});

const sortTable = (key: string) => {
  if (sortKey.value === key) {
    sortOrder.value *= -1;
  } else {
    sortKey.value = key;
    sortOrder.value = 1;
  }
};

// Open modal function
const openAddShoeModal = () => {
  modalOpen.value = true;
};

// Close modal function
const closeModal = () => {
  modalOpen.value = false;
};

// Handle form submission
const submitNewShoe = () => {
  // Logic to add the new shoe
  // For example, send this to an API or store it in your local table data
  console.log("New Shoe Details:", newShoe.value);
  closeModal();
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

          <!-- Add Shoe Button -->
          <div class="flex justify-end mb-4">
            <Button @click="openAddShoeModal" variant="outline" size="sm">Add New Shoe</Button>
          </div>

          <!-- Search & Table Section -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <Input v-model="searchQuery" placeholder="Search..." class="mb-4 w-full" />
            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead @click="sortTable('id')" class="cursor-pointer px-4 py-2">Shoe ID</TableHead>
                  <TableHead @click="sortTable('branch')" class="cursor-pointer px-4 py-2">Branch No.</TableHead>
                  <TableHead @click="sortTable('status')" class="cursor-pointer px-4 py-2">Status</TableHead>
                  <TableHead @click="sortTable('service')" class="cursor-pointer px-4 py-2">Service</TableHead>
                  <TableHead @click="sortTable('payment')" class="cursor-pointer px-4 py-2">Payment</TableHead>
                  <TableHead class="px-4 py-2">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="item in filteredTableData" :key="item.id" class="border-b last:border-b-0">
                  <TableCell class="px-4 py-2">{{ item.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.branch }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.status }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.service }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.payment }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button @click="openAddShoeModal" size="sm" variant="outline">Add Shoe</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>

        </main>

        <!-- Modal for Add Shoe -->
        <div v-if="modalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
          <div class="bg-white dark:bg-gray-800 rounded-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Add New Shoe</h2>
              <Button @click="closeModal" size="sm" variant="outline">Close</Button>
            </div>

            <!-- Add Shoe Form -->
            <div class="space-y-4">
              <div>
                <label for="shoeId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shoe ID</label>
                <Input id="shoeId" v-model="newShoe.shoeId" type="text" placeholder="Enter Shoe ID" />
              </div>
              <div>
                <label for="branchNo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Branch No.</label>
                <Input id="branchNo" v-model="newShoe.branchNo" type="text" placeholder="Enter Branch No." />
              </div>
              <div>
                <label for="service" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service</label>
                <Input id="service" v-model="newShoe.service" type="text" placeholder="Enter Service" />
              </div>
              <div>
                <label for="payment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment</label>
                <Input id="payment" v-model="newShoe.payment" type="text" placeholder="Enter Payment Status" />
              </div>
            </div>

            <div class="flex justify-end mt-4">
              <Button @click="submitNewShoe" variant="outline" color="green">Submit</Button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </SidebarProvider>
</template>
