<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";

// Title for page
const title = "Completed";

// Table Data for Branch Completed Table
const branchCompletedTableData = ref([
  { id: 1, status: "Completed", service: "Repair", payment: "Gcash" },
  { id: 2, status: "Completed", service: "Customization", payment: "Cash" },
  { id: 3, status: "Completed", service: "Cleaning", payment: "Cash" },
]);

// Table Data for Admin Completed Table
const adminCompletedTableData = ref([
  { batch: 1, id: 1, branch: "101",  shoe: "Nike Air Max", status: "Ready to Pick Up", dateTime: "2025-03-07 14:30" },
  { batch: 1, id: 2, branch: "203",  shoe: "Adidas UltraBoost", status: "Ready to Pick Up", dateTime: "2025-03-07 16:00" },
  { batch: 1, id: 3, branch: "305",  shoe: "Puma RS-X", status: "Completed", dateTime: "2025-03-07 18:45" },
  { batch: 2, id: 4, branch: "102",  shoe: "Reebok Classic", status: "Completed", dateTime: "2025-03-08 10:15" },
]);

// Modal State for Branch Completed Table
const branchModalOpen = ref(false);
const branchSelectedShoeDetails = ref({
  name: '',
  brand: '',
  description: '',
  picture: '',
  warranty: '',
});

// Modal State for Admin Completed Table
const adminModalOpen = ref(false);
const adminSelectedShoeDetails = ref({
  shoe: '',
  description: '',
  brand: '',
  image: '',
});

// Search Query
const searchQuery = ref("");

// Status Color Function
const statusColor = (status: string) => {
  if (status === "Completed") return "bg-green-500 text-white";
  if (status === "Ready to Pick Up") return "bg-yellow-300 text-black";
  return "bg-gray-300 text-black";
};

// Filtered Table Data for Branch Completed Table
const filteredBranchTableData = computed(() => {
  return branchCompletedTableData.value.filter((item) =>
    Object.values(item).some((val) => String(val).toLowerCase().includes(searchQuery.value.toLowerCase()))
  );
});

// Filtered Table Data for Admin Completed Table
const filteredAdminTableData = computed(() => {
  return adminCompletedTableData.value.filter((item) =>
    Object.values(item).some((val) => String(val).toLowerCase().includes(searchQuery.value.toLowerCase()))
  );
});

// Show Modal for Branch Completed Table
const showBranchModal = (shoe: any) => {
  branchSelectedShoeDetails.value = {
    name: "Air Max 97",  // Example static shoe name
    brand: "Nike",       // Example static brand
    description: "A legendary design that made waves when it first debuted. Air Max 97 features full-length Air cushioning for all-day comfort.",
    picture: "https://via.placeholder.com/150", // Placeholder image URL
    warranty: '1 Month Warranty',
  };
  branchModalOpen.value = true;
};

// Close Modal for Branch Completed Table
const closeBranchModal = () => {
  branchModalOpen.value = false;
};

// Show Modal for Admin Completed Table
const showAdminModal = (shoe: any) => {
  adminSelectedShoeDetails.value = {
    shoe: shoe.shoe,
    description: `Description for ${shoe.shoe}`,
    brand: "Brand: Nike",
    image: 'https://via.placeholder.com/150',
  };
  adminModalOpen.value = true;
};

// Close Modal for Admin Completed Table
const closeAdminModal = () => {
  adminModalOpen.value = false;
};

const selectedBatch = ref(null); 

const selectBatch = (batch: number) => {
  selectedBatch.value = batch;
};

const uniqueBatches = computed(() => {
  return Array.from(new Set(filteredAdminTableData.value.map(item => item.batch)));
});

const goBack = () => {
  selectedBatch.value = null;  // Go back to the main list of batches
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

          <!-- Branch Completed Table -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
            </div>
            
            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="cursor-pointer px-4 py-2">Shoe ID</TableHead>

                  <TableHead class="cursor-pointer px-4 py-2">Status</TableHead>
                  <TableHead class="cursor-pointer px-4 py-2">Service</TableHead>
                  <TableHead class="cursor-pointer px-4 py-2">Payment</TableHead>
                  <TableHead class="px-4 py-2">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="item in filteredBranchTableData" :key="item.id" class="border-b last:border-b-0">
                  <TableCell class="px-4 py-2">{{ item.id }}</TableCell>

                  <TableCell class="px-4 py-2">
                    <span class="px-2 py-1 rounded-lg font-semibold" :class="statusColor(item.status)">
                      {{ item.status }}
                    </span>
                  </TableCell>
                  <TableCell class="px-4 py-2">{{ item.service }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.payment }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button @click="showBranchModal(item)" size="sm" variant="outline">Details</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>

          <!-- Admin Completed Table -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">


            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
            </div>

            <!-- Display a back button if a batch is selected -->
            <div v-if="selectedBatch !== null" class="mb-4">
              <Button @click="goBack" class="mb-4">
                Back
              </Button>
            </div>


            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">Batch</TableHead>
                  <TableHead class="px-4 py-2 text-center">Shoe</TableHead>
                  <TableHead class="px-4 py-2 text-center">Branch No.</TableHead>
                  <TableHead class="px-4 py-2 text-center">Date & Time</TableHead>
                  <TableHead class="px-4 py-2 text-center">Status</TableHead>
                  <TableHead class="px-4 py-2 text-center">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <template v-if="selectedBatch === null">
                  <template v-for="(batchGroup, index) in uniqueBatches" :key="index">
                    <TableRow @click="selectBatch(batchGroup)" class="cursor-pointer bg-gray-100 dark:bg-gray-800">
                      <TableCell class="px-4 py-2 font-bold text-left w-full" colspan="7">
                        Batch {{ batchGroup }}
                      </TableCell>
                    </TableRow>
                  </template>
                </template>

                <template v-else>
                  <template v-for="item in filteredAdminTableData" :key="item.id">
                    <template v-if="item.batch === selectedBatch">
                      <TableRow class="border-b last:border-b-0">
                        <TableCell class="px-4 py-2 text-center">{{ item.batch }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.shoe }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.branch }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.dateTime }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">
                          <span class="px-2 py-1 rounded-lg font-semibold" :class="statusColor(item.status)">
                            {{ item.status }}
                          </span>
                        </TableCell>
                        <TableCell class="px-4 py-2 text-center">
                          <Button size="sm" variant="outline" @click="showBranchModal(item)">
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

    <!-- Modal for Branch Shoe Details -->
    <div v-if="branchModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Shoe Details</h2>
          <Button @click="closeBranchModal" size="sm" variant="outline">Close</Button>
        </div>
        <div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Shoe Name:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ branchSelectedShoeDetails.name }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Brand:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ branchSelectedShoeDetails.brand }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Description:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ branchSelectedShoeDetails.description }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Picture:</strong>
            <div class="flex justify-center items-center h-48 bg-gray-200 dark:bg-gray-700">
              <img :src="branchSelectedShoeDetails.picture" alt="Shoe Image" class="max-h-full max-w-full" />
            </div>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Warranty:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ branchSelectedShoeDetails.warranty }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Admin Shoe Details -->
    <div v-if="adminModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Shoe Details</h2>
          <Button @click="closeAdminModal" size="sm" variant="outline">Close</Button>
        </div>
        <div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Shoe:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ adminSelectedShoeDetails.shoe }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Brand:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ adminSelectedShoeDetails.brand }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Description:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ adminSelectedShoeDetails.description }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Picture:</strong>
            <div class="flex justify-center items-center h-48 bg-gray-200 dark:bg-gray-700">
              <img :src="adminSelectedShoeDetails.image" alt="Shoe Image" class="max-h-full max-w-full" />
            </div>
          </div>
        </div>
      </div>
    </div>

  </SidebarProvider>
</template>
