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
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
      <!-- Sidebar -->
      <AppSidebar class="bg-white w-64 min-h-screen" />

      
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">

       
        
        <header class="bg-white dark:bg-gray-800 shadow px-6 py-4 flex items-center justify-between w-full">
          <SidebarTrigger class="text-gray-500 dark:text-gray-400" />
          <h1>Welcome to the Admin Dashboard</h1>

        </header>

        <main class="p-6">
          <p class="text-gray-700">Dashboard Content Goes Here</p>
        </main>
      </div>
    </div>
  </SidebarProvider>
</template>

