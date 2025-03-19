<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";

// ShadCN table components
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";

// Admin Returned Shoes (first table)
const ReturnedShoes = ref([ 
  { id: 1, name: "Nike Air Max", shoeId: "AM123", dateTime: "2025-03-07 14:30" },
  { id: 2, name: "Adidas UltraBoost", shoeId: "UB456", dateTime: "2025-03-07 16:00" },
  { id: 3, name: "Puma RS-X", shoeId: "RS789", dateTime: "2025-03-07 18:45" },
]);

const tableData = ref([
  { id: 1, batch: 1, shoe: "Nike Air Max", service: "Repair", branch: "101", dateTime: "2025-03-07 14:30", status: "In Transit" },
  { id: 2, batch: 2, shoe: "Adidas UltraBoost", service: "Customization", branch: "203", dateTime: "2025-03-07 16:00", status: "To Shipped" },
  { id: 3, batch: 3, shoe: "Puma RS-X", service: "Cleaning", branch: "305", dateTime: "2025-03-07 18:45", status: "Received" },
]);

const searchQuery = ref("");
const sortKey = ref("");
const sortOrder = ref(1); // 1 = ascending, -1 = descending

const filteredTableData = computed(() => {
  if (!searchQuery.value) return tableData.value;
  return tableData.value.filter(item =>
    Object.values(item).some(value =>
      value.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  );
});




const sortTable = (key: string) => {
  if (sortKey.value === key) {
    sortOrder.value *= -1;
  } else {
    sortKey.value = key;
    sortOrder.value = 1;
  }
};

// Modal state for admin returned shoes
const showModal = ref(false);
const openModal = () => {
  showModal.value = true;
};
const closeModal = () => {
  showModal.value = false;
};

// Branch Returned Shoes (second table)
const modalOpen = ref(false);
const selectedShoeDetails = ref({
  name: '',
  brand: '',
  description: '',
  picture: '', // Placeholder for the shoe image URL
});

const returnedStatus = ref<boolean | null>(null); // null means no selection

const branchReturnedData = ref([
  { id: 1,  status: "To Shipped", service: "Repair", payment: "Paid" },
  { id: 2,  status: "In Transit", service: "Customization", payment: "Unpaid" },
  { id: 3,  status: "Received", service: "Cleaning", payment: "Unpaid" },
]);

const statusColor = (status: string) => {
  if (status === "To Shipped") return "bg-yellow-300 text-black";
  if (status === "In Transit") return "bg-orange-500 text-white";
  if (status === "Received") return "bg-green-500 text-white";
  return "bg-gray-300 text-black";
};

const showBranchModal = (shoe: any) => {
  selectedShoeDetails.value = {
    name: "Air Max 97",  // Example static shoe name
    brand: "Nike",       // Example static brand
    description: "A legendary design that made waves when it first debuted. Air Max 97 features full-length Air cushioning for all-day comfort.",
    picture: "https://via.placeholder.com/150", // Placeholder image URL
  };
  modalOpen.value = true;
};

const closeBranchModal = () => {
  modalOpen.value = false;
};

const handleReturnedStatus = (status: boolean) => {
  returnedStatus.value = status;
};

// Handling Batches
const selectedBatch = ref(null);  // Add selectedBatch to track the selected batch
const uniqueBatches = computed(() => {
  return Array.from(new Set(filteredTableData.value.map(item => item.batch)));
});

const selectBatch = (batch: number) => {
  selectedBatch.value = batch;
};


const goBack = () => {
  selectedBatch.value = null;  // Go back to the main list of batches
};
</script>

<template>
  <SidebarProvider>
    <div class="flex min-h-screen w-full bg-gray-100 dark:bg-gray-900">
      <!-- Sidebar -->
      <AppSidebar class="shrink-0" />
      <div class="flex flex-col flex-1 w-full">
        <Head :title="'Returned Shoes'" />
        <header class="bg-white dark:bg-gray-800 shadow px-6 h-20 flex items-center justify-center relative">
          <SidebarTrigger class="text-gray-500 dark:text-gray-400 absolute left-6" />
          <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 w-full text-center">
            Returned Shoes & Branch Returned
          </div>
        </header>

        <main class="flex-1 p-6 w-full">
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
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
                  <TableHead class="px-4 py-2 text-center">Service</TableHead>
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
                  <template v-for="item in filteredTableData" :key="item.id">
                    <template v-if="item.batch === selectedBatch">
                      <TableRow class="border-b last:border-b-0">
                        <TableCell class="px-4 py-2 text-center">{{ item.batch }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.shoe }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.service }}</TableCell>
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

       

        <div class="flex-1 p-6 w-full">
            <!-- Branch Returned Shoes Table -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
              <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
            </div>

              <Table class="w-full border rounded-lg">
                <TableHeader>
                  <TableRow class="bg-gray-200 dark:bg-gray-700">
                    <TableHead @click="sortTable('id')" class="cursor-pointer px-4 py-2">Shoe ID</TableHead>

                    <TableHead @click="sortTable('status')" class="cursor-pointer px-4 py-2">Status</TableHead>
                    <TableHead @click="sortTable('service')" class="cursor-pointer px-4 py-2">Service</TableHead>
                    <TableHead @click="sortTable('payment')" class="cursor-pointer px-4 py-2">Payment</TableHead>
                    <TableHead class="px-4 py-2">Action</TableHead>
                  </TableRow>
                </TableHeader>

                <TableBody>
                  <TableRow v-for="item in branchReturnedData" :key="item.id" class="border-b last:border-b-0">
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
   


        </div>
      </div>
        

        <!-- Admin Returned Shoes Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
          <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96">
            <div class="text-center font-semibold text-lg mb-4">List of Returned Shoes</div>
            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2">Shoe ID</TableHead>
                  <TableHead class="px-4 py-2">Shoe Name</TableHead>
                  <TableHead class="px-4 py-2">Date & Time</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="shoe in ReturnedShoes" :key="shoe.id" class="border-b last:border-b-0">
                  <TableCell class="px-4 py-2">{{ shoe.shoeId }}</TableCell>
                  <TableCell class="px-4 py-2">{{ shoe.name }}</TableCell>
                  <TableCell class="px-4 py-2">{{ shoe.dateTime }}</TableCell>
                </TableRow>
              </TableBody>
            </Table>
            <Button variant="outline" class="mt-4 w-full" @click="closeModal">Close</Button>
          </div>
        </div>

        <!-- Branch Returned Shoes Modal -->
        <div v-if="modalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
          <div class="bg-white dark:bg-gray-800 rounded-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Shoe Details</h2>
              <Button @click="closeBranchModal" size="sm" variant="outline">Close</Button>
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

  </SidebarProvider>
</template>
