<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";

// Import ShadCN table components
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";

// Modal state
const showModal = ref(false); // To control the visibility of the modal
const incomingShoes = ref([ // Static data for the list of incoming shoes
  { id: 1, name: "Nike Air Max", shoeId: "AM123", dateTime: "2025-03-07 14:30" },
  { id: 2, name: "Adidas UltraBoost", shoeId: "UB456", dateTime: "2025-03-07 16:00" },
  { id: 3, name: "Puma RS-X", shoeId: "RS789", dateTime: "2025-03-07 18:45" },
]);

const tableData = ref([
  { id: 1, branch: "101", status: "In Transit", service: "Repair", dateTime: "2025-03-07 14:30" },
  { id: 2, branch: "203", status: "To Ship", service: "Customization", dateTime: "2025-03-07 16:00" },
  { id: 3, branch: "305", status: "Delivered", service: "Cleaning", dateTime: "2025-03-07 18:45" },
]);

const searchQuery = ref("");
const sortKey = ref("");
const sortOrder = ref(1); // 1 = ascending, -1 = descending

// Computed filtered and sorted data
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

// Sort function
const sortTable = (key: string) => {
  if (sortKey.value === key) {
    sortOrder.value *= -1;
  } else {
    sortKey.value = key;
    sortOrder.value = 1;
  }
};

// Function to determine status color
const statusColor = (status: string) => {
  if (status === "In Transit") return "bg-orange-500 text-white";
  if (status === "To Ship") return "bg-yellow-500 text-black";
  if (status === "Delivered") return "bg-green-500 text-white";
  return "bg-gray-300 text-black";
};

// Open the modal when the "Details" button is clicked
const openModal = () => {
  showModal.value = true;
};

// Close the modal
const closeModal = () => {
  showModal.value = false;
};
</script>

<template>
  <SidebarProvider>
    <div class="flex min-h-screen w-full bg-gray-100 dark:bg-gray-900">
      <!-- Sidebar -->
      <AppSidebar class="shrink-0" />

      <!-- Main Content Area -->
      <div class="flex flex-col flex-1 w-full">
        <Head :title="'Incoming Shoes'" />

        <header class="bg-white dark:bg-gray-800 shadow px-6 h-20 flex items-center justify-center relative">
          <SidebarTrigger class="text-gray-500 dark:text-gray-400 absolute left-6" />
          <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 w-full text-center">
            Incoming Shoes
          </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 w-full">
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            
            <!-- Search Input -->
            <Input v-model="searchQuery" placeholder="Search..." class="mb-4 w-full" />

            <!-- Table -->
            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead @click="sortTable('id')" class="cursor-pointer px-4 py-2">Batch ID</TableHead>
                  <TableHead @click="sortTable('branch')" class="cursor-pointer px-4 py-2">Branch No.</TableHead>
                  <TableHead @click="sortTable('service')" class="cursor-pointer px-4 py-2">Service</TableHead>
                  <TableHead @click="sortTable('dateTime')" class="cursor-pointer px-4 py-2">Date & Time</TableHead>
                  <TableHead class="px-4 py-2">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="item in filteredTableData" :key="item.id" class="border-b last:border-b-0">
                  <TableCell class="px-4 py-2">{{ item.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.branch }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.dateTime }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <span class="px-2 py-1 rounded-lg font-semibold" :class="statusColor(item.status)">
                      {{ item.status }}
                    </span>
                  </TableCell>
                  <TableCell class="px-4 py-2">
                    <Button size="sm" variant="outline" @click="openModal">Details</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>
        </main>
      </div>
    </div>

    <!-- Modal for showing list of incoming shoes -->
    <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96">
        <div class="text-center font-semibold text-lg mb-4">List of Incoming Shoes</div>
        
        <!-- List of incoming shoes -->
        <Table class="w-full border rounded-lg">
          <TableHeader>
            <TableRow class="bg-gray-200 dark:bg-gray-700">
              <TableHead class="px-4 py-2">Shoe ID</TableHead>
              <TableHead class="px-4 py-2">Shoe Name</TableHead>
              <TableHead class="px-4 py-2">Date & Time</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="shoe in incomingShoes" :key="shoe.id" class="border-b last:border-b-0">
              <TableCell class="px-4 py-2">{{ shoe.shoeId }}</TableCell>
              <TableCell class="px-4 py-2">{{ shoe.name }}</TableCell>
              <TableCell class="px-4 py-2">{{ shoe.dateTime }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>

        <!-- Close Button -->
        <Button variant="outline" class="mt-4 w-full" @click="closeModal">Close</Button>
      </div>
    </div>
  </SidebarProvider>
</template>
