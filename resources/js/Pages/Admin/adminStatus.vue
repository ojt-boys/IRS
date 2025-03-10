<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { ChevronDown, ChevronRight, ArrowUp, ArrowDown } from "lucide-vue-next";

const title = "Status Repairing";

const tableData = ref([
  { batch: 1, id: 1, branch: "101", service: "Cleaning", shoe: "Nike Air Max", status: "Repairing", dateTime: "2025-03-07 14:30" },
  { batch: 1, id: 2, branch: "203", service: "Repair", shoe: "Adidas UltraBoost", status: "Repaired", dateTime: "2025-03-07 16:00" },
  { batch: 1, id: 3, branch: "305", service: "Polishing", shoe: "Puma RS-X", status: "Failed", dateTime: "2025-03-07 18:45" }, // 🔴 New failed entry
  { batch: 2, id: 4, branch: "102", service: "Sole Replacement", shoe: "Reebok Classic", status: "Repaired", dateTime: "2025-03-08 10:15" },
  { batch: 2, id: 5, branch: "204", service: "Waterproofing", shoe: "New Balance 574", status: "Repairing", dateTime: "2025-03-08 12:45" },
]);


const searchQuery = ref("");
const expandedBatches = ref<number[]>([]);
const sortedBatches = ref<Record<number, { column: string; order: "asc" | "desc" }>>({});

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

const toggleBatch = (batch: number) => {
  if (expandedBatches.value.includes(batch)) {
    expandedBatches.value = expandedBatches.value.filter(b => b !== batch);
  } else {
    expandedBatches.value.push(batch);
  }
};

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


const getStatusClass = (status: string) => {
  return status === "Repairing" ? "bg-yellow-500 text-white" :
         status === "Repaired" ? "bg-green-500 text-white" :
         status === "Failed" ? "bg-red-500 text-white" :  // 🔴 Added failed status
         "bg-gray-300 text-black";
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

            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">Batch</TableHead>
                  <TableHead class="px-4 py-2 text-center cursor-pointer">Shoe</TableHead>
                  <TableHead class="px-4 py-2 text-center cursor-pointer">Service</TableHead>
                  <TableHead class="px-4 py-2 text-center cursor-pointer">Branch No.</TableHead>
                  <TableHead class="px-4 py-2 text-center cursor-pointer">Date & Time</TableHead>
                  <TableHead class="px-4 py-2 text-center">Status</TableHead>
                  <TableHead class="px-4 py-2 text-center">Action</TableHead>
                </TableRow>
              </TableHeader>

              <TableBody>
                <template v-for="(batchGroup, index) in uniqueBatches" :key="index">
                  <TableRow @click="toggleBatch(batchGroup)" class="cursor-pointer bg-gray-100 dark:bg-gray-800">
  <TableCell class="px-4 py-2 font-bold text-left w-full" colspan="7">
    <button class="flex items-center w-full text-left p-2">
      <component :is="expandedBatches.includes(batchGroup) ? ChevronDown : ChevronRight" class="w-4 h-4 mr-2" />
      Batch {{ batchGroup }}
    </button>
  </TableCell>
</TableRow>


                  <TableRow v-if="expandedBatches.includes(batchGroup)" class="bg-gray-200 dark:bg-gray-700">
                    <TableHead class="px-4 py-2 text-center cursor-pointer" @click="sortBatchContents(batchGroup, 'shoe')">
                      Sort
                      <component v-if="sortedBatches[batchGroup]?.column === 'shoe'" :is="sortedBatches[batchGroup].order === 'asc' ? ArrowUp : ArrowDown" class="w-4 h-4 inline-block ml-1" />
                    </TableHead>
                  </TableRow>

                  <template v-if="expandedBatches.includes(batchGroup)">
                    <TableRow v-for="item in getSortedBatchItems(batchGroup)" :key="item.id" class="border-b last:border-b-0">
                      <TableCell class="px-4 py-2 text-center">{{ batchGroup }}</TableCell>
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
                        <Button size="sm" variant="outline">Details</Button>
                      </TableCell>
                    </TableRow>
                  </template>
                </template>
              </TableBody>
            </Table>
          </div>
        </main>
      </div>
    </div>
  </SidebarProvider>
</template>
