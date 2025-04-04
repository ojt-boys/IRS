<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { ChevronRight, ArrowUp, ArrowDown } from "lucide-vue-next";
// import { Inertia } from '@inertiajs/inertia';

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
const currentItem = ref<any>(null); // The item that's currently being viewed for confirmation

// Confirmation modal for Mark as Done or Returned actions
const showConfirmationModal = ref(false); // Modal visibility
const confirmationMessage = ref(''); // Action message

// Modal for shoe details
const showDetailsModal = ref(false);
const selectedShoeDetails = ref<any>(null);

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

// Mark as Done action
const markAsDone = (item: any) => {
  console.log("Mark as Received clicked for", item);
  item.status = "Completed";  // Example: Update the status to 'Completed'
};

// Returned action
const returnItem = (item: any) => {
  console.log("Returned clicked for", item);
  item.status = "Returned";  // Example: Update the status to 'Returned'
};

// Get sorted items within a batch
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

// Show confirmation modal for Mark as Done
const confirmMarkAsDone = (item: any) => {
  currentItem.value = item;
  confirmationMessage.value = "Received";
  showConfirmationModal.value = true;
};

// Show confirmation modal for Returned
const confirmReturnItem = (item: any) => {
  currentItem.value = item;
  confirmationMessage.value = "Return";
  showConfirmationModal.value = true;
};

// Close the confirmation modal
const closeConfirmationModal = () => {
  showConfirmationModal.value = false;
  currentItem.value = null; // Reset the current item
};

// Perform action after confirmation
const confirmAction = () => {
  if (confirmationMessage.value === "Received") {
    markAsDone(currentItem.value);
  } else if (confirmationMessage.value === "Return") {
    returnItem(currentItem.value);
  }
  closeConfirmationModal(); // Close the modal after action
};

// Show shoe details in modal
const showShoeDetails = (shoe: any) => {
  selectedShoeDetails.value = shoe;
  showDetailsModal.value = true;
};

// Close shoe details modal
const closeDetailsModal = () => {
  showDetailsModal.value = false;
};







////// SHOE TECH /////

const AsearchQuery = ref("");
const AactiveBatch = ref<number | null>(null);
const AsortedBatches = ref<Record<number, { column: string; order: "asc" | "desc" }>>({});

// Modal states
const AcurrentItem = ref<any>(null); // The item that's currently being viewed for confirmation

// Confirmation modal for Mark as Done or Returned actions
const AshowConfirmationModal = ref(false); // Modal visibility
const AconfirmationMessage = ref(''); // Action message

// Modal for shoe details
const AshowDetailsModal = ref(false);
const AselectedShoeDetails = ref<any>(null);

// Filtered table data based on search query
const AfilteredTableData = computed(() => {
  if (!AsearchQuery.value) return tableData.value;

  return tableData.value.filter(item =>
    Object.values(item).some(value =>
      value.toString().toLowerCase().includes(AsearchQuery.value.toLowerCase())
    )
  );
});

// Get unique batch numbers after filtering
const AuniqueBatches = computed(() => {
  return Array.from(new Set(AfilteredTableData.value.map(item => item.batch)));
});

// Mark as Done action
const AmarkAsDone = (item: any) => {
  console.log("Mark as Done clicked for", item);
  item.status = "Completed";  // Example: Update the status to 'Completed'
};

// Returned action
const AreturnItem = (item: any) => {
  console.log("Returned clicked for", item);
  item.status = "Returned";  // Example: Update the status to 'Returned'
};

// Get sorted items within a batch
const AgetSortedBatchItems = (batch: number) => {
  const batchItems = AfilteredTableData.value.filter(item => item.batch === batch);
  const sorting = AsortedBatches.value[batch];

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
const AgetStatusClass = (status: string) => {
  return status === "Repairing" ? "bg-yellow-500 text-white" :
         status === "Repaired" ? "bg-green-500 text-white" :
         status === "Failed" ? "bg-red-500 text-white" :
         "bg-gray-300 text-black";
};

// Show batch details
const AshowBatchDetails = (batch: number) => {
  AactiveBatch.value = batch;
};

// Go back to the batch list
const AgoBackToBatches = () => {
  AactiveBatch.value = null;
};

// Show confirmation modal for Mark as Done
const AconfirmMarkAsDone = (item: any) => {
  AcurrentItem.value = item;
  AconfirmationMessage.value = "Mark as Done";
  AshowConfirmationModal.value = true;
};

// Show confirmation modal for Returned
const AconfirmReturnItem = (item: any) => {
  AcurrentItem.value = item;
  AconfirmationMessage.value = "Return";
  AshowConfirmationModal.value = true;
};

// Close the confirmation modal
const AcloseConfirmationModal = () => {
  AshowConfirmationModal.value = false;
  AcurrentItem.value = null; // Reset the current item
};

// Perform action after confirmation
const AconfirmAction = () => {
  if (AconfirmationMessage.value === "Mark as Done") {
    AmarkAsDone(AcurrentItem.value);
  } else if (AconfirmationMessage.value === "Return") {
    AreturnItem(AcurrentItem.value);
  }
  AcloseConfirmationModal(); // Close the modal after action
};

// Show shoe details in modal
const AshowShoeDetails = (shoe: any) => {
  AselectedShoeDetails.value = shoe;
  AshowDetailsModal.value = true;
};

// Close shoe details modal
const AcloseDetailsModal = () => {
  AshowDetailsModal.value = false;
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
                  <TableRow class="bg-gray-200 dark:bg-gray-700 w-full">
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
                        <Button size="sm" variant="outline" @click="showShoeDetails(item)">Details</Button>
                      </TableCell>
                      <TableCell>
                        <!-- Mark as Done button, shown when status is 'Repaired' -->
                        <div v-if="item.status === 'Repaired'">
                          <Button size="sm" variant="outline" @click="confirmMarkAsDone(item)">Received</Button>
                        </div>
                        <!-- Returned button, shown when status is 'Failed' -->
                        <div v-if="item.status === 'Failed'">
                          <Button size="sm" variant="outline" @click="confirmReturnItem(item)">Returned</Button>
                        </div>
                      </TableCell>
                    </TableRow>
                  </template>
                </TableBody>
              </Table>
            </div>
          </div>




           <!-- Shoe tech -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between mb-4">
              <Input v-model="AsearchQuery" placeholder="Search..." class="w-1/2" />
            </div>

            <Table v-if="AactiveBatch === null" class="w-full border rounded-lg">
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
                <template v-for="(batchGroup, index) in AuniqueBatches" :key="index">
                  <TableRow @click="AshowBatchDetails(batchGroup)" class="cursor-pointer bg-gray-100 dark:bg-gray-800">
                    <TableCell class="px-4 py-2 font-bold text-left w-full" colspan="7">
                      <button class="flex items-center w-full text-left p-2">
                        Batch {{ batchGroup }}
                      </button>
                    </TableCell>
                  </TableRow>
                </template>
              </TableBody>
            </Table>

            <div v-if="AactiveBatch !== null">
              <Button @click="AgoBackToBatches" class="mb-4">Back</Button>
              <Table class="w-full border rounded-lg">
                <TableHeader>
                  <TableRow class="bg-gray-200 dark:bg-gray-700 w-full">
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
                  <template v-for="item in AgetSortedBatchItems(AactiveBatch)" :key="item.id">
                    <TableRow>
                      <TableCell class="px-4 py-2 text-center">{{ AactiveBatch }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.shoe }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.service }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.branch }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">{{ item.dateTime }}</TableCell>
                      <TableCell class="px-4 py-2 text-center">
                        <span :class="['px-3 py-1 rounded-lg text-sm font-semibold', AgetStatusClass(item.status)]">
                          {{ item.status }}
                        </span>
                      </TableCell>
                      <TableCell class="px-4 py-2 text-center">
                        <Button size="sm" variant="outline" @click="AshowShoeDetails(item)">Details</Button>
                      </TableCell>
                      <TableCell>
                        <!-- Mark as Done button, shown when status is 'Repairing' -->
                        <div v-if="item.status === 'Repairing'">
                          <Button size="sm" variant="outline" @click="AconfirmMarkAsDone(item)">Mark as Done</Button>
                        </div>
                        <!-- Returned button, shown when status is 'Failed' -->
                        <div v-if="item.status === 'Failed' || item.status === 'Repaired'">
                          <Button size="sm" variant="outline" @click="AconfirmReturnItem(item)">Returned</Button>
                        </div>
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

    <!-- Shoe Details Modal -->
    <div v-if="AshowDetailsModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="text-xl mb-4">Shoe Details</div>
        <div class="mb-4">
          <strong>Shoe:</strong> {{ AselectedShoeDetails.shoe }}<br>
          <strong>Service:</strong> {{ AselectedShoeDetails.service }}<br>
          <strong>Branch No:</strong> {{ AselectedShoeDetails.branch }}<br>
          <strong>Date & Time:</strong> {{ AselectedShoeDetails.dateTime }}
        </div>
        <div class="flex justify-end">
          <Button @click="AcloseDetailsModal" variant="outline">Close</Button>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="AshowConfirmationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="text-xl mb-4">Confirm Action</div>
        <p>Are you sure you want to {{ AconfirmationMessage }} this item?</p>
        <div class="flex justify-end gap-4 mt-4">
          <Button @click="AcloseConfirmationModal" variant="outline">Cancel</Button>
          <Button @click="AconfirmAction" variant="danger">Confirm</Button>
        </div>
      </div>
    </div>






                      <!-- Shoe Details Modal -->
                      <div v-if="showDetailsModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="text-xl mb-4">Shoe Details</div>
        <div class="mb-4">
          <strong>Shoe:</strong> {{ selectedShoeDetails.shoe }}<br>
          <strong>Service:</strong> {{ selectedShoeDetails.service }}<br>
          <strong>Branch No:</strong> {{ selectedShoeDetails.branch }}<br>
          <strong>Date & Time:</strong> {{ selectedShoeDetails.dateTime }}
        </div>
        <div class="flex justify-end">
          <Button @click="closeDetailsModal" variant="outline">Close</Button>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="showConfirmationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="text-xl mb-4">Confirm Action</div>
        <p>Are you sure you want to {{ confirmationMessage }} this item?</p>
        <div class="flex justify-end gap-4 mt-4">
          <Button @click="closeConfirmationModal" variant="outline">Cancel</Button>
          <Button @click="confirmAction" variant="danger">Confirm</Button>
        </div>
      </div>
    </div>



  </SidebarProvider>
</template>







