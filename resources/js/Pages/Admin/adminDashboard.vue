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


const title = "Dashboard";

// Sample table data
const tableData = ref([
  { id: 1, branch: "101", status: "Incoming", service: "Repair", payment: "Pending" },
  { id: 2, branch: "203", status: "For Checking", service: "Customization", payment: "Paid" },
  { id: 3, branch: "305", status: "Completed", service: "Cleaning", payment: "Paid" },
]);

const searchQuery = ref("");
const sortKey = ref("");
const sortOrder = ref(1);

const filteredTableData = computed(() => {
  let filtered = tableData.value.filter((item) =>
    Object.values(item).some((val) => String(val).toLowerCase().includes(searchQuery.value.toLowerCase()))
  );

  if (sortKey.value) {
    filtered.sort((a, b) => {
      const aValue = a[sortKey.value];
      const bValue = b[sortKey.value];
      return (aValue > bValue ? 1 : -1) * sortOrder.value;
    });
  }

  return filtered;
});

const sortTable = (key: string) => {
  if (sortKey.value === key) {
    sortOrder.value *= -1;
  } else {
    sortKey.value = key;
    sortOrder.value = 1;
  }
};

// Sample chart data
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

          <!-- Search & Table Section -->
          <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
            <Input v-model="searchQuery" placeholder="Search..." class="mb-4 w-full" />
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
                <TableRow v-for="item in filteredTableData" :key="item.id" class="border-b last:border-b-0">
                  <TableCell class="px-4 py-2">{{ item.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.branch }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.status }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.service }}</TableCell>
                  <TableCell class="px-4 py-2">{{ item.payment }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button size="sm" variant="outline">Details</Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>

        </main>
      </div>
    </div>
  </SidebarProvider>
</template>

