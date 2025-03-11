<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { ChevronRight, ArrowUp, ArrowDown } from "lucide-vue-next";
import { Inertia } from '@inertiajs/inertia';  // Import Inertia for navigation

const title = "Job Order";

const tableData = ref([
  { batch: 1, id: 1, branch: "101", service: "Cleaning", shoe: "Nike Air Max", status: "Repairing", dateTime: "2025-03-07 14:30" },
  { batch: 1, id: 2, branch: "203", service: "Repair", shoe: "Adidas UltraBoost", status: "Repaired", dateTime: "2025-03-07 16:00" },
  { batch: 1, id: 3, branch: "305", service: "Polishing", shoe: "Puma RS-X", status: "Failed", dateTime: "2025-03-07 18:45" },
  { batch: 2, id: 4, branch: "102", service: "Sole Replacement", shoe: "Reebok Classic", status: "Repaired", dateTime: "2025-03-08 10:15" },
  { batch: 2, id: 5, branch: "204", service: "Waterproofing", shoe: "New Balance 574", status: "Repairing", dateTime: "2025-03-08 12:45" },
]);

const searchQuery = ref("");
const activeBatch = ref<number | null>(null);
const sortedBatches = ref<Record<number, { column: string; order: "asc" | "desc" }>>({});

// Modal states
const showModal = ref(false); // Controls visibility of the modal
const modalMessage = ref(''); // The message to be displayed in the modal
const currentItem = ref<any>(null); // The item that's currently being viewed for confirmation

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

// Sorting logic
const sortBatchContents = (batch: number, column: string) => {
  if (sortedBatches.value[batch]?.column === column) {
    sortedBatches.value[batch].order = sortedBatches.value[batch].order === "asc" ? "desc" : "asc";
  } else {
    sortedBatches.value[batch] = { column, order: "asc" };
  }
};

const getSortedBatchItems = (batch: number) => {
  const batchItems = filteredTableData.value.filter(item => item.batch === batch);
  const sorting = sortedBatches.value[batch];

  if (sorting) {
    return [...batchItems].sort((a, b) => {
      const valueA = a[sorting.column as keyof typeof a].toString();
      const valueB = b[sorting.column as keyof typeof b].toString();
      return sorting.order === "asc" ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
    });
  }

  return batchItems;
};

// Status styling
const getStatusClass = (status: string) => {
  return status === "Repairing" ? "bg-yellow-500 text-white" :
         status === "Repaired" ? "bg-green-500 text-white" :
         status === "Failed" ? "bg-red-500 text-white" :
         "bg-gray-300 text-black";
};

// Show batch details
const showBatchDetails = (batch: number) => {
  activeBatch.value = batch;
};

// Go back to the batch list
const goBackToBatches = () => {
  activeBatch.value = null;
};

// Open confirmation modal with the right message
const openConfirmationModal = (item: any) => {
  currentItem.value = item;

  if (item.status === "Repairing") {
    modalMessage.value = "Are you sure the shoe is Repaired?";
  } else if (item.status === "Repaired") {
    modalMessage.value = "Are you sure you want to send it to Returned?";
  } else if (item.status === "Failed") {
    modalMessage.value = "Are you sure you want to refund it?";
  }

  showModal.value = true;
};

// Close the modal
const closeModal = () => {
  showModal.value = false;
  currentItem.value = null;
};

// Confirm action in modal
const confirmAction = () => {
  console.log(`Action confirmed for item ID: ${currentItem.value.id}, Status: ${currentItem.value.status}`);

  // If the status is "Repaired" or "Failed", navigate to the returned page
  if (currentItem.value.status === "Repaired" || currentItem.value.status === "Failed") {
    Inertia.visit('/admin/adminReturned'); // Navigate to the returned page
  }
  
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
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
            </div>

            <Table v-if="activeBatch === null" class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">Batch</TableHead>
                  <TableHead class="px-4 py-2 text-center">Shoe</TableHead>
                  <TableHead class="px-4 py-2 text-center">Service</TableHead>
                  <TableHead class="px-4 py-2 text-center">Branch No.</TableHead>
                  <TableHead class="px-4 py-2 text-center">Date & Time</TableHead>
                  <TableHead class="px-4 py-2 text-center">Action</TableHead>
                </TableRow>
              </TableHeader>

              <TableBody>
                <template v-for="(batchGroup, index) in uniqueBatches" :key="index">
                  <TableRow @click="showBatchDetails(batchGroup)" class="cursor-pointer bg-gray-100 dark:bg-gray-800">
                    <TableCell class="px-4 py-2 font-bold text-left w-full" colspan="7">
                      <button class="flex items-center w-full text-left p-2">
                        Batch {{ batchGroup }}
                      </button>
                    </TableCell>
                  </TableRow>
                </template>
              </TableBody>
            </Table>

            <div v-if="activeBatch !== null">
              <Button @click="goBackToBatches" class="mb-4">Back</Button>
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
                  <template v-for="item in getSortedBatchItems(activeBatch)" :key="item.id">
                    <TableRow>
                      <TableCell class="px-4 py-2 text-center">{{ activeBatch }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.shoe }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.service }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.branch }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.dateTime }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">
                        <span :class="['px-3 py-1 rounded-lg text-sm font-semibold', getStatusClass(item.status)]">
                          {{ item.status }}
                        </span>
                      </TableCell>
                      <TableCell class="px-4 py-2 text-center">
                        <Button size="sm" variant="outline" @click="openConfirmationModal(item)">Details</Button>
                      </TableCell>
                    </TableRow>
                  </template>
                </TableBody>
              </Table>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="text-xl mb-4">{{ modalMessage }}</div>
        <div class="flex justify-end space-x-4">
          <Button @click="closeModal" variant="outline">No</Button>
          <Button @click="confirmAction" variant="primary">Yes</Button>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>

