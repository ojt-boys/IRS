<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";

const title = "Payments";

const tableData = ref([
  { batch: 1, id: 1, branch: "101", service: "Cleaning", shoe: "Nike Air Max", status: "Unpaid", dateTime: "2025-03-07 14:30" },
  { batch: 1, id: 2, branch: "203", service: "Repair", shoe: "Adidas UltraBoost", status: "Paid", dateTime: "2025-03-07 16:00" },
  { batch: 1, id: 3, branch: "305", service: "Polishing", shoe: "Puma RS-X", status: "Refund", dateTime: "2025-03-07 18:45" },
  { batch: 2, id: 4, branch: "102", service: "Sole Replacement", shoe: "Reebok Classic", status: "Paid", dateTime: "2025-03-08 10:15" },
]);

const searchQuery = ref("");
const activeBatch = ref<number | null>(null);

// Modal States
const modalOpen = ref(false);
const selectedShoeDetails = ref({
  shoe: 'Nike Air Max',
  description: 'This is a popular model known for its comfort and style.',
  brand: 'Nike',
  image: 'https://via.placeholder.com/150',
});

// Filtered table data based on search query
const filteredTableData = computed(() => {
  if (!searchQuery.value) return tableData.value;
  return tableData.value.filter(item =>
    Object.values(item).some(value =>
      value.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  );
});

// Get unique batch numbers after filtering
const uniqueBatches = computed(() => {
  return Array.from(new Set(filteredTableData.value.map(item => item.batch)));
});

// Function to show batch details
const showBatchDetails = (batch: number) => {
  activeBatch.value = batch;
};

// Go back to the batch list
const goBackToBatches = () => {
  activeBatch.value = null;
};

// Function to open the modal with shoe details
const showShoeDetails = (shoe: any) => {
  selectedShoeDetails.value = {
    shoe: shoe.shoe,
    description: `Description for ${shoe.shoe}`,
    brand: "Brand: Nike",
    image: 'https://via.placeholder.com/150',
  };
  modalOpen.value = true; // Open the modal when a shoe is selected
};

// Function to close the shoe details modal
const closeModal = () => {
  modalOpen.value = false; // Close the modal
};



const statusColor = (status: string) => {
  if (status === "Unpaid") return "bg-yellow-300 text-black";
  if (status === "Refund") return "bg-orange-500 text-black";
  if (status === "Paid") return "bg-green-500 text-white";
  return "bg-gray-300 text-black";
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
            </div>

            <!-- Display a back button if a batch is selected -->
            <div v-if="activeBatch !== null" class="mb-4">
              <Button @click="goBackToBatches" class="mb-4">
                Back
              </Button>
            </div>

            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">Batch</TableHead>
                  <TableHead class="px-4 py-2 text-center">Shoe</TableHead>
                  <TableHead class="px-4 py-2 text-center">Service</TableHead>
                  <TableHead class="px-4 py-2 text-center">Branch No.</TableHead>
                  <TableHead class="px-4 py-2 text-center">Date & Time</TableHead>
                  <TableHead class="px-4 py-2 text-center">Status</TableHead>
                  <TableHead class="px-4 py-2 text-center">Action</TableHead>
                </TableRow>
              </TableHeader>

              <TableBody>
                <template v-if="activeBatch === null">
                  <template v-for="(batchGroup, index) in uniqueBatches" :key="index">
                    <TableRow @click="showBatchDetails(batchGroup)" class="cursor-pointer bg-gray-100 dark:bg-gray-800">
                      <TableCell class="px-4 py-2 font-bold text-left w-full" colspan="7">
                        Batch {{ batchGroup }}
                      </TableCell>
                    </TableRow>
                  </template>
                </template>

                <template v-else>
                  <template v-for="item in filteredTableData" :key="item.id">
                    <template v-if="item.batch === activeBatch">
                      <TableRow class="border-b last:border-b-0">
                        <TableCell class="px-4 py-2 text-center">{{ item.batch }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.shoe }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.service }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.branch }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.dateTime }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">                    <span class="px-2 py-1 rounded-lg font-semibold" :class="statusColor(item.status)">
                      {{ item.status }}
                    </span>

                        </TableCell>
                        <TableCell class="px-4 py-2 text-center">
                          <Button size="sm" variant="outline" @click="showShoeDetails(item)">
                            Detail
                          </Button>
                        </TableCell>
                      </TableRow>
                    </template>
                  </template>
                </template>
              </TableBody>
            </Table>
          </div>
        </main>
      </div>
    </div>

    <!-- Modal for shoe details -->
    <div v-if="modalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Shoe Details</h2>
          <Button @click="closeModal" size="sm" variant="outline">Close</Button>
        </div>
        <div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Shoe:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ selectedShoeDetails.shoe }}</p>
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
              <img :src="selectedShoeDetails.image" alt="Shoe Image" class="max-h-full max-w-full" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>


