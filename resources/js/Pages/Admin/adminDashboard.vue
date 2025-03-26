<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import BarChart from "@/Components/BarChart.vue";
import GaugeChart from "@/Components/GaugeChart.vue";

// Modal state and shoe details
const modalOpen = ref(false);
const selectedShoeDetails = ref({
  name: '',
  brand: '',
  description: '',
  picture: '', // Placeholder for the shoe image URL
});

const title = "Dashboard";

// Sample table data for Admin (for the repair shop)
const adminTableData = ref([
  { id: 1, branch: "101", status: "Failed", service: "Repair", payment: "Unpaid" },
  { id: 2, branch: "203", status: "In Transit", service: "Customization", payment: "Paid" },
  { id: 3, branch: "305", status: "To Shipped", service: "Cleaning", payment: "Paid" },
  { id: 3, branch: "405", status: "Back Job", service: "Cleaning", payment: "Paid" },
]);

// Sample table data for Branch
const branchTableData = ref([
  { id: 1, status: "To Shipped", service: "Repair", payment: "Paid" },
  { id: 2, status: "In Transit", service: "Customization", payment: "Paid" },
  { id: 3, status: "Failed", service: "Cleaning", payment: "Unpaid" },
]);

// Filters and sorting
const searchQuery = ref("");
const sortKey = ref("");
const sortOrder = ref(1);

const filteredAdminTableData = computed(() => {
  return adminTableData.value.filter((item) =>
    Object.values(item).some((val) => String(val).toLowerCase().includes(searchQuery.value.toLowerCase()))
  ).sort((a, b) => {
    if (sortKey.value) {
      const aValue = a[sortKey.value];
      const bValue = b[sortKey.value];
      return (aValue > bValue ? 1 : -1) * sortOrder.value;
    }
    return 0;
  });
});

const filteredBranchTableData = computed(() => {
  return branchTableData.value.filter((item) =>
    Object.values(item).some((val) => String(val).toLowerCase().includes(searchQuery.value.toLowerCase()))
  ).sort((a, b) => {
    if (sortKey.value) {
      const aValue = a[sortKey.value];
      const bValue = b[sortKey.value];
      return (aValue > bValue ? 1 : -1) * sortOrder.value;
    }
    return 0;
  });
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

// Chart data
const profitsData = ref({
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
  data: [4000, 3000, 2000, 2780, 1890, 2390],
});

const ordersData = ref({
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
  data: [2400, 1398, 9800, 3908, 4800, 3800],
});

const earningsData = ref({
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
  data: [2400, 2210, 2290, 2000, 2181, 2500],
});





const statusColor = (status: string) => {
  if (status === "To Shipped") return "bg-yellow-300 text-black";
  if (status === "Back Job") return "bg-orange-500 text-white";
  if (status === "In Transit") return "bg-green-500 text-white";
  if (status === "Failed") return "bg-red-500 text-white";
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

          <!-- Stats Section (Orders & Profits) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
              <h2 class="text-sm text-gray-500 dark:text-gray-400">Orders</h2>
              <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">2,560</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
              <h2 class="text-sm text-gray-500 dark:text-gray-400">Profits</h2>
              <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">$6,250</p>
            </div>
          </div>

          <!-- Charts Section (3 Bar Charts) -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <GaugeChart title="Profits" :value="6250" :max="10000" />
            <BarChart title="Orders" :chartData="ordersData" color="#82ca9d" />
            <BarChart title="Earnings" :chartData="earningsData" color="#ffc658" />
          </div>

          <!-- Admin Table Section -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between mb-4">
              <Input v-model="searchQuery" placeholder="Search..." class="w-1/2" />
            </div>
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
                <TableRow v-for="item in filteredAdminTableData" :key="item.id" class="border-b last:border-b-0">
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

          <!-- Branch Table Section -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
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
                <TableRow v-for="item in filteredBranchTableData" :key="item.id" class="border-b last:border-b-0">
                  <TableCell class="px-4 py-2">{{ item.id }}</TableCell>
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
            </div>
          </div>
        </div>

      </div>
    </div>
  </SidebarProvider>
</template>
