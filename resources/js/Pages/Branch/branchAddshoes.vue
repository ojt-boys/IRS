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

const addShoeModalOpen = ref(false); // State for the add shoe modal
const shoeDetails = ref({
  shoeId: '',
  branchNo: '',
  service: '', // Service type
  payment: '', // Payment method
});

const isEditShoeModalOpen = ref(false); // State for the edit shoe modal

const title = "Branch Add Shoes";

// Define the shape of a shoe object including the `selected` property
interface Shoe {
  id: number;
  branch: string;
  status: string;
  service: string;
  payment: string;
  selected?: boolean; // Add the selected field
}

// Sample table data with `selected` property added to each shoe
const tableData = ref<Shoe[]>([
  { id: 1, branch: "101", status: "To Shipped", service: "Repair", payment: "Pending", selected: false },
  { id: 2, branch: "203", status: "In Transit", service: "Customization", payment: "Paid", selected: false },
  { id: 3, branch: "305", status: "Received", service: "Cleaning", payment: "Paid", selected: false },
]);

const statusColor = (status: string) => {
  if (status === "To Shipped") return "bg-yellow-300 text-black";
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
      const aValue = a[sortKey.value as keyof Shoe];
      const bValue = b[sortKey.value as keyof Shoe];
      return (aValue > bValue ? 1 : -1) * sortOrder.value;
    });
  }

  return filtered;
});


const sendModalOpen = ref(false); // State to control the modal visibility

// Function to open the modal
const sendShoeModal = () => {
  sendModalOpen.value = true;
};

// Function to close the modal
const closeSendModal = () => {
  sendModalOpen.value = false;
}

// Function to handle confirmation of sending the shoe
const confirmSendShoe = () => {
  // Add logic to handle sending the shoe
  console.log('Shoe has been sent!');
  closeSendModal(); // Close the modal after confirming
};


const isAllSelected = computed(() => {
  return tableData.value.every(item => item.selected);
});

const toggleSelectAll = () => {
  const isSelected = isAllSelected.value;
  tableData.value.forEach((item) => {
    item.selected = !isSelected;
  });
};

// Function to handle individual row checkbox change
const handleRowSelection = () => {
  // This will automatically update the "select all" checkbox state
};;


// Function to sort the table
const sortTable = (key: string) => {
  if (sortKey.value === key) {
    sortOrder.value *= -1;
  } else {
    sortKey.value = key;
    sortOrder.value = 1;
  }
};

// Open modal function with static sample shoe data for Details
const showModal = (shoe: any) => {
  selectedShoeDetails.value = {
    name: "Air Max 97",  // Example static shoe name
    brand: "Nike",       // Example static brand
    description: "A legendary design that made waves when it first debuted. Air Max 97 features full-length Air cushioning for all-day comfort.",
    picture: "https://via.placeholder.com/150", // Placeholder image URL
  };
  modalOpen.value = true;
};

// Close Details modal
const closeModal = () => {
  modalOpen.value = false;
};

// Open modal for adding a shoe
const showAddShoeModal = () => {
  addShoeModalOpen.value = true;
};

// Close add shoe modal
const closeAddShoeModal = () => {
  addShoeModalOpen.value = false;
  // Reset inputs
  shoeDetails.value = { shoeId: '', branchNo: '', service: '', payment: '' };
};

// Open Edit Modal and populate the selected shoe for editing
const showEditModal = (shoe: any) => {
  // Static data for editing
  selectedShoeDetails.value = {
    name: shoe.name || "Air Max 97",
    brand: shoe.brand || "Nike",
    description: shoe.description || "A legendary design that made waves when it first debuted. Air Max 97 features full-length Air cushioning for all-day comfort.",
    picture: shoe.picture || "https://via.placeholder.com/150",
  };
  isEditShoeModalOpen.value = true;
};

// Close the Edit Modal
const closeEditShoeModal = () => {
  isEditShoeModalOpen.value = false;
};

// Function to simulate saving changes to the shoe (static data)
const saveShoeChanges = () => {
  console.log('Changes saved for:', selectedShoeDetails.value);
  isEditShoeModalOpen.value = false;
};

// Function to handle the form submission (you can modify this as needed)
const addShoe = () => {
  const newShoe = {
    id: 4, 
    branch: "404",
    status: "New",
    service: "Cleaning",
    payment: "Pending",
    selected: false, // Add selected property for the new shoe
  };

  closeAddShoeModal(); // Close the modal after adding the shoe
};

// Dropdown options
const serviceOptions = ['REGULAR', 'DEEP CLEAN', 'PREMIUM', 'EXTRAS'];
const paymentOptions = ['Gcash', 'Paymaya', 'Cash', 'Other'];

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
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between mb-4">
            
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
  
              <Button variant="outline" @click="showAddShoeModal">
                Add New Shoe
              </Button>
            </div>

            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <!-- Checkbox for bulk selection (select/deselect all) -->
                  <TableHead class="px-4 py-2">
                    <input type="checkbox" @change="toggleSelectAll" :checked="isAllSelected" />
                  </TableHead>
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
                  <!-- Checkbox for each row -->
                  <TableCell class="px-4 py-2">
                    <input type="checkbox" v-model="item.selected" @change="handleRowSelection" />
                  </TableCell>
                  <TableCell class="px-4 py-2">{{ item.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.branch }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <span class="px-2 py-1 rounded-lg font-semibold" :class="statusColor(item.status)">
                      {{ item.status }}
                    </span>
                  </TableCell>
                  <TableCell class="px-4 py-2">{{ item.service }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.payment }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button @click="showModal(item)" size="sm" variant="outline">Details</Button>
                    <Button @click="showEditModal(item)" size="sm" variant="outline" class="ml-2">Edit</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>

            <div class="flex justify-end mt-4">
              <Button variant="outline" @click="sendShoeModal">
                Send
              </Button>
            </div>
          </div>


        </main>




        <!-- Send Shoe Modal -->
<div v-if="sendModalOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white dark:bg-gray-800 rounded-lg w-96 p-6">
    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Confirm Send Shoe</h3>
    <p class="text-gray-600 dark:text-gray-300 mb-4">Are you sure you want to send the selected shoe? This action cannot be undone.</p>
    <div class="flex justify-end space-x-2">
      <Button variant="outline" @click="closeSendModal">Cancel</Button>
      <Button variant="outline" @click="confirmSendShoe">Confirm</Button>
    </div>
  </div>
</div>


        <!-- Modal for Add Shoe -->
        <div v-if="addShoeModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
          <div class="bg-white dark:bg-gray-800 rounded-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Add New Shoe</h2>
              <Button @click="closeAddShoeModal" size="sm" variant="outline">Close</Button>
            </div>
            <div>
              <div class="mb-4">
                <Input v-model="shoeDetails.shoeId" placeholder="Shoe ID" class="w-full" />
              </div>
              <div class="mb-4">
                <Input v-model="shoeDetails.branchNo" placeholder="Branch No." class="w-full" />
              </div>
              <div class="mb-4">
                <label for="service" class="block text-gray-600 dark:text-gray-300">Service</label>
                <select v-model="shoeDetails.service" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
                  <option v-for="option in serviceOptions" :key="option" :value="option">{{ option }}</option>
                </select>
              </div>
              <div class="mb-4">
                <label for="payment" class="block text-gray-600 dark:text-gray-300">Method of Payment</label>
                <select v-model="shoeDetails.payment" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
                  <option v-for="option in paymentOptions" :key="option" :value="option">{{ option }}</option>
                </select>
              </div>
              <Button @click="addShoe" variant="outline">
                Add Shoe
              </Button>
            </div>
          </div>
        </div>

        <!-- Modal for Edit Shoe -->
        <div v-if="isEditShoeModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
          <div class="bg-white dark:bg-gray-800 rounded-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Shoe</h2>
              <Button @click="closeEditShoeModal" size="sm" variant="outline">Close</Button>
            </div>
            <div>
              <div class="mb-4">
                <Input v-model="shoeDetails.shoeId" placeholder="Shoe ID" class="w-full" disabled />
              </div>
              <div class="mb-4">
                <Input v-model="shoeDetails.branchNo" placeholder="Branch No." class="w-full" />
              </div>
              <div class="mb-4">
                <label for="service" class="block text-gray-600 dark:text-gray-300">Service</label>
                <select v-model="shoeDetails.service" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
                  <option v-for="option in serviceOptions" :key="option" :value="option">{{ option }}</option>
                </select>
              </div>
              <div class="mb-4">
                <label for="payment" class="block text-gray-600 dark:text-gray-300">Method of Payment</label>
                <select v-model="shoeDetails.payment" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
                  <option v-for="option in paymentOptions" :key="option" :value="option">{{ option }}</option>
                </select>
              </div>
              <Button @click="saveShoeChanges" variant="outline">
                Save Changes
              </Button>
            </div>
          </div>
        </div>

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
            </div>
          </div>
        </div>
      </div>
    </div>
  </SidebarProvider>
</template>



