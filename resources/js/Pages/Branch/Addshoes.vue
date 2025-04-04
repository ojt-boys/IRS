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
  customerName: '',
  customerAddress: '',
  customerNumber: '',
});

const addShoeModalOpen = ref(false); // State for the add shoe modal

const shoeDetails = ref({
  shoeId: "",
  branchNo: "",
  service: "",
  payment: "",
  shoeType: "Pair",
  quotation: 0,
  customerName: "",
  customerNumber: "",
  customerAddress: "",
  shoeImage: "", // Placeholder for the image URL
});

// Initialization for Add Shoe Modal
const initializeShoeDetails = () => {
  shoeDetails.value = {
    shoeId: "",
    branchNo: "",
    service: "",
    payment: "",
    shoeType: "Pair",
    quotation: 0,
    customerName: "",
    customerNumber: "",
    customerAddress: "",
    shoeImage: "", // Reset shoe image
  };
};

const isEditShoeModalOpen = ref(false); // State for the edit shoe modal

const title = "Branch Add Shoes";

// Define the shape of a shoe object including the `selected` property
interface Shoe {
  id: number;
  branch: string;
  status: string;
  service: string;
  payment: string;
  selected?: boolean; 
}

// Sample table data with `selected` property added to each shoe
const tableData = ref<Shoe[]>([
  { id: 1, branch: "101", status: "To Shipped",  service: "Repair", payment: "Pending", selected: false },
  { id: 2, branch: "101", status: "In Transit", service: "Customization", payment: "Paid", selected: false },
  { id: 3, branch: "101", status: "Received", service: "Cleaning", payment: "Paid", selected: false },
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

// Handle select all checkbox logic
const isAllSelected = computed(() => {
  return tableData.value.every(item => item.selected);
});

const toggleSelectAll = () => {
  const isSelected = isAllSelected.value;
  tableData.value.forEach((item) => {
    item.selected = !isSelected;
  });
};

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
    customerName: "Customer A",
    customerAddress: 'Pila Laguna',
    customerNumber: '09323498431',
  };
  modalOpen.value = true;
};

// Close Details modal
const closeModal = () => {
  modalOpen.value = false;
};

// Open modal for adding a shoe
const showAddShoeModal = () => {
  initializeShoeDetails();  // Initialize shoe details before showing the modal
  addShoeModalOpen.value = true;
};

// Close add shoe modal
const closeAddShoeModal = () => {
  addShoeModalOpen.value = false;
  // Reset inputs
  initializeShoeDetails(); // Reset the shoe details to default values
};

const showEditModal = (shoe: any) => {
  // Initialize shoe details before populating
  initializeShoeDetails();

  // Set the details of the selected shoe to edit
  shoeDetails.value.shoeId = shoe.shoeId || "";
  shoeDetails.value.branchNo = shoe.branchNo || "";
  shoeDetails.value.service = shoe.service || "";
  shoeDetails.value.payment = shoe.payment || "";
  shoeDetails.value.shoeType = shoe.shoeType || "Pair";
  shoeDetails.value.quotation = shoe.quotation || 0;
  shoeDetails.value.customerName = shoe.customerName || "";
  shoeDetails.value.customerNumber = shoe.customerNumber || "";
  shoeDetails.value.customerAddress = shoe.customerAddress || "";

  // Open the edit modal
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

// Function to calculate the quotation based on the selected service
const calculateQuotation = () => {
  // You can modify this logic to reflect actual pricing logic
  const servicePricing: Record<string, number> = {
    "Full Reglue": 1000,
    "Partial Reglue": 500,
    "Re stitch": 800,
  };

  shoeDetails.value.quotation = servicePricing[shoeDetails.value.service] || 0;
};

// Function to handle the form submission (you can modify this as needed)
const addShoe = () => {
  const newShoe = {
    id: 4, 
    branch: "404",
    status: "New",
    service: shoeDetails.value.service,
    payment: shoeDetails.value.payment,
    selected: false, // Add selected property for the new shoe
  };

  closeAddShoeModal(); // Close the modal after adding the shoe
};

// Dropdown options
const serviceOptions = ['Full Reglue', 'Partial Reglue', 'Re stitch'];
const paymentOptions = ['Gcash', 'Paymaya', 'Cash', 'Other'];

// Handle image upload
const handleImageUpload = (event: Event) => {
  const fileInput = event.target as HTMLInputElement;
  if (fileInput.files && fileInput.files[0]) {
    const file = fileInput.files[0];
    // For simplicity, you could convert the image to a URL, or use any other file handling method
    shoeDetails.value.shoeImage = URL.createObjectURL(file); // You can use a backend to upload the file
    console.log('Uploaded Image:', shoeDetails.value.shoeImage);
  }
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
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
              <Button variant="outline" @click="showAddShoeModal">Add New Shoe</Button>
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
                    <input type="checkbox" v-model="item.selected" />
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
              <Button variant="outline" @click="sendShoeModal">Send</Button>
            </div>
          </div>
        </main>

        <!-- Modal Sections -->
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

        <div v-if="addShoeModalOpen" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
  <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/2 max-w-lg max-h-[90vh] overflow-y-auto">
    <h2 class="text-lg font-semibold text-center">Add New Shoe</h2>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Shoe ID</label>
      <!-- Shoe ID field is now readonly -->
      <Input v-model="shoeDetails.shoeId" placeholder="Enter Shoe ID" class="w-full" readonly />
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Branch No</label>
      <!-- Branch No field is now readonly -->
      <Input v-model="shoeDetails.branchNo" placeholder="Enter Branch No" class="w-full" readonly />
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Service</label>
      <select v-model="shoeDetails.service" @change="calculateQuotation" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
        <option v-for="option in serviceOptions" :key="option" :value="option">{{ option }}</option>
      </select>
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Shoe Type</label>
      <select v-model="shoeDetails.shoeType" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
        <option value="Pair">Pair</option>
        <option value="Single">Single</option>
      </select>
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Type of Payments</label>
      <select v-model="shoeDetails.payment" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
        <option v-for="option in paymentOptions" :key="option" :value="option">{{ option }}</option>
      </select>
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Customer Name</label>
      <Input v-model="shoeDetails.customerName" placeholder="Enter Customer Name" class="w-full" />
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Customer Number</label>
      <Input v-model="shoeDetails.customerNumber" placeholder="Enter Customer Number" class="w-full" type="tel" />
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Customer Address</label>
      <Input v-model="shoeDetails.customerAddress" placeholder="Enter Customer Address" class="w-full" />
    </div>
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Estimated Quotation:</label>
      <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">₱{{ shoeDetails.quotation }}</p>
    </div>
    
    <!-- Image Upload Section -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Upload Shoe Image</label>
      <input type="file" @change="handleImageUpload" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md" />
    </div>

    <div class="flex justify-end">
      <Button @click="addShoe" class="mr-2">Add Shoe</Button>
      <Button variant="outline" @click="closeAddShoeModal">Cancel</Button>
    </div>
  </div>
</div>


        <!-- Modal for Edit Shoe -->
<!-- Modal for Edit Shoe -->
<div v-if="isEditShoeModalOpen" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
  <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/2 max-w-lg max-h-[90vh] overflow-y-auto">
    <h2 class="text-lg font-semibold text-center">Edit Shoe</h2>

    <!-- Shoe ID -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Shoe ID</label>
      <!-- Shoe ID field is now readonly -->
      <Input v-model="shoeDetails.shoeId" placeholder="Enter Shoe ID" class="w-full" readonly />
    </div>

    <!-- Branch No -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Branch No</label>
      <!-- Branch No field is now readonly -->
      <Input v-model="shoeDetails.branchNo" placeholder="Enter Branch No" class="w-full" readonly />
    </div>

    <!-- Service -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Service</label>
      <select v-model="shoeDetails.service" @change="calculateQuotation" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
        <option v-for="option in serviceOptions" :key="option" :value="option">{{ option }}</option>
      </select>
    </div>

    <!-- Shoe Type -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Shoe Type</label>
      <select v-model="shoeDetails.shoeType" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
        <option value="Pair">Pair</option>
        <option value="Single">Single</option>
      </select>
    </div>

    <!-- Type of Payments -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Type of Payments</label>
      <select v-model="shoeDetails.payment" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md">
        <option v-for="option in paymentOptions" :key="option" :value="option">{{ option }}</option>
      </select>
    </div>

    <!-- Customer Name -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Customer Name</label>
      <Input v-model="shoeDetails.customerName" placeholder="Enter Customer Name" class="w-full" />
    </div>

    <!-- Customer Number -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Customer Number</label>
      <Input v-model="shoeDetails.customerNumber" placeholder="Enter Customer Number" class="w-full" type="tel" />
    </div>

    <!-- Customer Address -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Customer Address</label>
      <Input v-model="shoeDetails.customerAddress" placeholder="Enter Customer Address" class="w-full" />
    </div>

    <!-- Estimated Quotation -->
    <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Estimated Quotation:</label>
      <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">₱{{ shoeDetails.quotation }}</p>
    </div>

        <!-- Image Upload Section -->
        <div class="mb-4">
      <label class="block text-gray-600 dark:text-gray-300">Upload Shoe Image</label>
      <input type="file" @change="handleImageUpload" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-2 rounded-md" />
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end">
      <Button @click="saveShoeChanges" class="mr-2">Save Changes</Button>
      <Button variant="outline" @click="closeEditShoeModal">Cancel</Button>
    </div>
  </div>
</div>




          <!-- Modal for Shoe Details -->
          <div v-if="modalOpen" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/2 max-w-lg max-h-[90vh] overflow-y-auto">
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
                <strong class="text-gray-600 dark:text-gray-300">Customer Name:</strong>
                <p class="text-gray-800 dark:text-gray-200">{{ selectedShoeDetails.customerName }}</p>
              </div>
              <div class="mb-4">
                <strong class="text-gray-600 dark:text-gray-300">Customer Address:</strong>
                <p class="text-gray-800 dark:text-gray-200">{{ selectedShoeDetails.customerAddress }}</p>
              </div>
              <div class="mb-4">
                <strong class="text-gray-600 dark:text-gray-300">Customer Number:</strong>
                <p class="text-gray-800 dark:text-gray-200">{{ selectedShoeDetails.customerNumber }}</p>
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
