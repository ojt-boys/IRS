<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";

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

// Modal States
const modalOpen = ref(false);
const selectedShoeDetails = ref({
  shoe: 'Nike Air Max',
  description: 'This is a popular model known for its comfort and style.',
  brand: 'Nike',
  image: 'https://via.placeholder.com/150',
});

// Popup States for Accept/Decline
const isPopupVisible = ref(false);
const isDeclinePopup = ref(false);
const declineReason = ref("");

// Static Shoe Tech Data
const shoeTechList = ref([
  { id: 1, name: 'John Doe' },
  { id: 2, name: 'Jane Smith' },
  { id: 3, name: 'Alex Johnson' },
]);

const selectedShoeTech = ref(null);

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

// Modal handling for "Accept" and "Decline"
const confirmAction = (action: string, item: any) => {
  // Show the confirmation popup
  isPopupVisible.value = true;
  if (action === 'Decline') {
    isDeclinePopup.value = true; // Show the decline reason input
  } else {
    isDeclinePopup.value = false; // Show the accept confirmation
  }
  console.log(`Action: ${action} on item`, item);
};

const handleDecline = () => {
  // Handle decline logic here (e.g., store the reason and update status)
  console.log(`Declined for reason: ${declineReason.value}`);
  isPopupVisible.value = false; // Close the popup
};

const handleAccept = () => {
  // Handle accept logic here and assign the selected shoe tech
  if (selectedShoeTech.value) {
    console.log(`Shoe Tech Assigned: ${selectedShoeTech.value.name}`);
    // You can store or process the shoe tech assignment here
  } else {
    console.log('No Shoe Tech selected');
  }
  isPopupVisible.value = false; // Close the popup
};






//// SHOE TECH ////
const AsearchQuery = ref("");
const AselectedBatch = ref<number | null>(null);

// Modal States for shoe details
const AmodalOpen = ref(false);
const AselectedShoeDetails = ref({
  shoe: 'Nike Air Max',
  description: 'This is a popular model known for its comfort and style.',
  brand: 'Nike',
  image: 'https://via.placeholder.com/150',
});

// Popup States for Accept/Decline
const AisPopupVisible = ref(false);
const AisDeclinePopup = ref(false);
const AdeclineReason = ref("");

// Filtered table data based on search query
const AfilteredTableData = computed(() => {
  if (!AsearchQuery.value) return tableData.value;  // Ensure you're using the correct table data reference
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

// Function to select a batch and display its data
const AselectBatch = (batch: number) => {
  AselectedBatch.value = batch;
};

// Function to go back to the list of batches
const AgoBack = () => {
  AselectedBatch.value = null;
};

// Function to open the modal with shoe details
const AshowShoeDetails = (shoe: any) => {
  AselectedShoeDetails.value = {
    shoe: shoe.shoe,
    description: `Description for ${shoe.shoe}`,
    brand: "Brand: Nike",
    image: 'https://via.placeholder.com/150',
  };
  AmodalOpen.value = true; // Open the modal when a shoe is selected
};

// Function to close the shoe details modal
const AcloseModal = () => {
  AmodalOpen.value = false; // Close the modal
};

// Modal handling for "Accept" and "Decline"
const AconfirmAction = (action: string, item: any) => {
  // Show the confirmation popup
  AisPopupVisible.value = true;
  if (action === 'Decline') {
    AisDeclinePopup.value = true; // Show the decline reason input
  } else {
    AisDeclinePopup.value = false; // Show the accept confirmation
  }
  console.log(`Action: ${action} on item`, item);
};

const AhandleDecline = () => {
  // Handle decline logic here (e.g., store the reason and update status)
  console.log(`Declined for reason: ${AdeclineReason.value}`);
  AisPopupVisible.value = false; // Close the popup
};

const AhandleAccept = () => {
  // Handle accept logic here
  console.log('Accepted');
  AisPopupVisible.value = false; // Close the popup
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
                          <!-- Detail Button -->
                          <Button size="sm" variant="outline" @click="showShoeDetails(item)">
                            Detail
                          </Button>

                          <!-- Accept Button -->
                          <Button size="sm" variant="outline" class="ml-2 text-green-600 border-green-600 hover:bg-green-600 hover:text-white"
                                  @click="confirmAction('Accept', item)">
                            Accept
                          </Button>

                          <!-- Decline Button -->
                          <Button size="sm" variant="outline" class="ml-2 text-red-600 border-red-600 hover:bg-red-600 hover:text-white"
                                  @click="confirmAction('Decline', item)">
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













            <!-- Shoe Tech ASSESSMENT -->

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between mb-4">
              <Input v-model="AsearchQuery" placeholder="Search..." class="w-1/2" />
            </div>

            <!-- Display a back button if a batch is selected -->
            <div v-if="AselectedBatch !== null" class="mb-4">
              <Button @click="AgoBack" class="mb-4">
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
                <template v-if="AselectedBatch === null">
                  <template v-for="(batchGroup, index) in AuniqueBatches" :key="index">
                    <TableRow @click="AselectBatch(batchGroup)" class="cursor-pointer bg-gray-100 dark:bg-gray-800">
                      <TableCell class="px-4 py-2 font-bold text-left w-full" colspan="7">
                        Batch {{ batchGroup }}
                      </TableCell>
                    </TableRow>
                  </template>
                </template>

                <!-- Display selected batch data -->
                <template v-else>
                  <template v-for="item in AfilteredTableData" :key="item.id">
                    <template v-if="item.batch === AselectedBatch">
                      <TableRow class="border-b last:border-b-0">
                        <TableCell class="px-4 py-2 text-center">{{ item.batch }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.shoe }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.service }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.branch }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">{{ item.dateTime }}</TableCell>
                        <TableCell class="px-4 py-2 text-center">
                          <!-- Detail Button -->
                          <Button size="sm" variant="outline" @click="AshowShoeDetails(item)">
                            Detail
                          </Button>

                          <!-- Accept Button -->
                          <Button size="sm" variant="outline" class="ml-2 text-green-600 border-green-600 hover:bg-green-600 hover:text-white"
                                  @click="AconfirmAction('Accept', item)">
                            Accept
                          </Button>

                          <!-- Decline Button -->
                          <Button size="sm" variant="outline" class="ml-2 text-red-600 border-red-600 hover:bg-red-600 hover:text-white"
                                  @click="AconfirmAction('Decline', item)">
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






        <!-- Modal for shoe details -->
        <div v-if="AmodalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Shoe Details</h2>
          <Button @click="AcloseModal" size="sm" variant="outline">Close</Button>
        </div>
        <div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Shoe:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ AselectedShoeDetails.shoe }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Brand:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ AselectedShoeDetails.brand }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Description:</strong>
            <p class="text-gray-800 dark:text-gray-200">{{ AselectedShoeDetails.description }}</p>
          </div>
          <div class="mb-4">
            <strong class="text-gray-600 dark:text-gray-300">Picture:</strong>
            <div class="flex justify-center items-center h-48 bg-gray-200 dark:bg-gray-700">
              <img :src="AselectedShoeDetails.image" alt="Shoe Image" class="max-h-full max-w-full" />
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal for confirmation (Accept/Decline) -->
<div v-if="AisPopupVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        Are you sure you want to {{ AisDeclinePopup ? 'Decline' : 'Accept' }}?
      </h2>
      <Button @click="AisPopupVisible = false" size="sm" variant="outline">Close</Button>
    </div>
    
    <!-- Decline reason input -->
    <div v-if="AisDeclinePopup">
      <Input v-model="AdeclineReason" placeholder="Enter reason for decline" class="mb-4 w-full" />
    </div>

    <div class="flex justify-between">
      <Button @click="AisPopupVisible = false" class="bg-gray-500 text-white hover:bg-gray-600">
        Cancel
      </Button>
      <Button @click="AisDeclinePopup ? AhandleDecline() : AhandleAccept()" class="bg-green-500 text-white hover:bg-green-600">
        Confirm
      </Button>
    </div>
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

<!-- Modal for confirmation (Accept/Decline) -->
<div v-if="isPopupVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        Are you sure you want to {{ isDeclinePopup ? 'Decline' : 'Accept' }}?
      </h2>
      <Button @click="isPopupVisible = false" size="sm" variant="outline">Close</Button>
    </div>
    
    <!-- Decline reason input -->
    <div v-if="isDeclinePopup">
      <Input v-model="declineReason" placeholder="Enter reason for decline" class="mb-4 w-full" />
    </div>

    <!-- Shoe Tech Dropdown (Only shown when accepting) -->
    <div v-if="!isDeclinePopup">
      <div class="mb-4">
        <label for="shoe-tech" class="text-gray-800 dark:text-gray-200">Assign Shoe Tech</label>
        <select id="shoe-tech" v-model="selectedShoeTech" class="w-full border border-gray-300 p-2 rounded-md mt-2">
          <option v-for="tech in shoeTechList" :key="tech.id" :value="tech">
            {{ tech.name }} (ID: {{ tech.id }})
          </option>
        </select>
      </div>
    </div>

    <div class="flex justify-between">
      <Button @click="isPopupVisible = false" class="bg-gray-500 text-white hover:bg-gray-600">
        Cancel
      </Button>
      <Button 
        @click="isDeclinePopup ? handleDecline() : handleAccept()"
        class="bg-green-500 text-white hover:bg-green-600"
      >
        Confirm
      </Button>
    </div>
  </div>
</div>


  </SidebarProvider>
</template>
