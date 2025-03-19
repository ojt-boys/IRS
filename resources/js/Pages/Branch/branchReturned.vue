<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";

// Modal state and shoe details
const modalOpen = ref(false);
const selectedShoeDetails = ref({
  name: '',
  brand: '',
  description: '',
  picture: '', // Placeholder for the shoe image URL
});

// Added state for tracking returned shoes status
const returnedStatus = ref<boolean | null>(null); // null means no selection

const title = "Branch Returned";

// Sample table data
const tableData = ref([
  { id: 1, branch: "101", status: "To Shipped", service: "Repair", payment: "Gcash" },
  { id: 2, branch: "203", status: "In Transit", service: "Customization", payment: "Cash" },
  { id: 3, branch: "305", status: "Received", service: "Cleaning", payment: "Cash" },
]);

const statusColor = (status: string) => {
  if (status === "To Shipped") return "bg-yellow-500 text-white";
  if (status === "In Transit") return "bg-orange-500 text-white";
  if (status === "Received") return "bg-green-500 text-white";
  return "bg-gray-300 text-black";
};


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

// Open modal function with static sample shoe data
const showModal = (shoe: any) => {
  selectedShoeDetails.value = {
    name: "Air Max 97",  // Example static shoe name
    brand: "Nike",       // Example static brand
    description: "A legendary design that made waves when it first debuted. Air Max 97 features full-length Air cushioning for all-day comfort.",
    picture: "https://via.placeholder.com/150", // Placeholder image URL
  };
  modalOpen.value = true;
};

// Close modal
const closeModal = () => {
  modalOpen.value = false;
};

// Handle the "Returned Shoes?" status
const handleReturnedStatus = (status: boolean) => {
  returnedStatus.value = status;
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
                  <TableCell class="px-4 py-2">                    <span class="px-2 py-1 rounded-lg font-semibold" :class="statusColor(item.status)">
                      {{ item.status }}
                    </span></TableCell>
                  <TableCell class="px-4 py-2">{{ item.service }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.payment }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button @click="showModal(item)" size="sm" variant="outline">Details</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>

        </main>

        <!-- Modal for Shoe Details -->
        <div v-if="modalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
          <div class="bg-white dark:bg-gray-800 rounded-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Shoe Details</h2>
              <Button @click="closeModal" size="sm" variant="outline">Close</Button>
            </div>
            <div>
              <div class="mb-4">
                <strong class="text-gray-600 dark:text-gray-300">Shoe Name:</strong>
                <p class="text-gray-800 dark:text-gray-200">{{ selectedShoeDetails.name }}</p>
              </div>
              <div class="mb-4">
                <strong class="text-gray-600 dark:text-gray-300">Brand:</strong>
                <p class="text-gray-800 dark:text-gray-200">{{ selectedShoeDetails.brand }}</p>
              </div>
              <div class="mb-4">
                <strong class="text-gray-600 dark:text-gray-300">Description:</strong>
                <p class="text-gray-800 dark:text-gray-200">{{ selectedShoeDetails.description }}</p>
              </div>
              <div class="mb-4">
                <strong class="text-gray-600 dark:text-gray-300">Picture:</strong>
                <div class="flex justify-center items-center h-48 bg-gray-200 dark:bg-gray-700">
                  <img :src="selectedShoeDetails.picture" alt="Shoe Image" class="max-h-full max-w-full" />
                </div>
              </div>
              <!-- Added: Return Shoe Section -->
              <div class="mt-6">
                <strong class="text-gray-600 dark:text-gray-300">Returned Shoes?</strong>
                <div class="mt-4">
                  <Button @click="handleReturnedStatus(true)" :disabled="returnedStatus !== null" variant="outline" class="mr-2">
                    Yes
                  </Button>
                  <Button @click="handleReturnedStatus(false)" :disabled="returnedStatus !== null" variant="outline">
                    No
                  </Button>
                </div>
                <p v-if="returnedStatus !== null" class="mt-2 text-gray-800 dark:text-gray-200">
                  <strong>Status:</strong> {{ returnedStatus === true ? "Yes, Returned" : "No, Not Returned" }}
                </p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </SidebarProvider>
</template>
