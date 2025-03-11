<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { ChevronDown, ChevronRight, ArrowUp, ArrowDown } from "lucide-vue-next";
import { Inertia } from '@inertiajs/inertia'; 





const title = "Assessment";

const tableData = ref([
  { batch: 1, id: 1, branch: "101", service: "Cleaning", shoe: "Nike Air Max", dateTime: "2025-03-07 14:30" },
  { batch: 1, id: 2, branch: "203", service: "Repair", shoe: "Adidas UltraBoost", dateTime: "2025-03-07 16:00" },
  { batch: 1, id: 3, branch: "305", service: "Polishing", shoe: "Puma RS-X", dateTime: "2025-03-07 18:45" },
  { batch: 2, id: 4, branch: "102", service: "Sole Replacement", shoe: "Reebok Classic", dateTime: "2025-03-08 10:15" },
  { batch: 2, id: 5, branch: "204", service: "Waterproofing", shoe: "New Balance 574", dateTime: "2025-03-08 12:45" },
]);

const searchQuery = ref("");
const selectedBatch = ref<number | null>(null);

// Popup States
const isPopupVisible = ref(false);
const isDeclinePopup = ref(false);
const actionToConfirm = ref("");
const declineReason = ref("");

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

// Function to select a batch and display its data
const selectBatch = (batch: number) => {
  selectedBatch.value = batch;
};

// Function to go back to the list of batches
const goBack = () => {
  selectedBatch.value = null;
};

// Function to show confirmation popup
const confirmAction = (action: string) => {
  actionToConfirm.value = action;
  isDeclinePopup.value = action === 'Decline';
  isPopupVisible.value = true;
};

// Function to handle Accept action
const handleAccept = () => {
  isPopupVisible.value = false;
  console.log('Accepted');
  // Redirect with Inertia visit
  Inertia.visit('/admin/adminJoborder');
};

// Function to handle Decline action
const handleDecline = () => {
  isPopupVisible.value = false;
  console.log('Declined with reason:', declineReason.value);
  // Redirect with Inertia visit
  Inertia.visit('/admin/adminJoborder');
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
                  <TableHead class="px-4 py-2 text-center">Action</TableHead>
                </TableRow>
              </TableHeader>

              <TableBody>
                <!-- Show batches or the selected batch data -->
                <template v-if="selectedBatch === null">
                  <template v-for="(batchGroup, index) in uniqueBatches" :key="index">
                    <TableRow @click="selectBatch(batchGroup)" class="cursor-pointer bg-gray-100 dark:bg-gray-800">
                      <TableCell class="px-4 py-2 font-bold text-left w-full" colspan="7">
                        Batch {{ batchGroup }}
                      </TableCell>
                    </TableRow>
                  </template>
                </template>

                <!-- Display selected batch data -->
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
                          <Button size="sm" variant="outline" class="text-green-600 border-green-600 hover:bg-green-600 hover:text-white"
                                  @click="confirmAction('Accept')">
                            Accept
                          </Button>
                          <Button size="sm" variant="outline" class="ml-2 text-red-600 border-red-600 hover:bg-red-600 hover:text-white"
                                  @click="confirmAction('Decline')">
                            Decline
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

    <!-- Popup Modal for confirmation -->
    <div v-if="isPopupVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <div v-if="isDeclinePopup">
          <h3 class="text-lg font-semibold mb-4">Are you sure you want to decline?</h3>
          <Input v-model="declineReason" placeholder="Enter reason for decline" class="mb-4 w-full" />
        </div>
        <div v-else>
          <h3 class="text-lg font-semibold mb-4">Are you sure you want to accept?</h3>
        </div>
        <div class="flex justify-between">
          <Button @click="isPopupVisible = false" class="bg-gray-500 text-white hover:bg-gray-600">
            Cancel
          </Button>
          <Button @click="isDeclinePopup ? handleDecline() : handleAccept()" class="bg-green-500 text-white hover:bg-green-600">
            Confirm
          </Button>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>
