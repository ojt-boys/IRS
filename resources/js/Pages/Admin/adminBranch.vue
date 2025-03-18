<script setup lang="ts">
import AppSidebar from '@/Components/AppSidebar.vue';
import { SidebarProvider, SidebarTrigger } from '@/Components/ui/sidebar';
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { Table, TableHeader, TableHead, TableBody, TableRow, TableCell } from "@/Components/ui/table";

const title = "Account Management";
const searchQuery = ref("");

const tableData = ref([
  { id: 1, name: "John Doe", branch: "101", password: "********" },
  { id: 2, name: "Jane Smith", branch: "102", password: "********" },
  { id: 3, name: "Alice Johnson", branch: "103", password: "********" }
]);
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
              <Button variant="outline">Add User</Button>
            </div>

            <Table class="w-full border rounded-lg">
              <TableHeader>
                <TableRow class="bg-gray-200 dark:bg-gray-700">
                  <TableHead class="px-4 py-2 text-left">ID</TableHead>
                  <TableHead class="px-4 py-2 text-left">Name</TableHead>
                  <TableHead class="px-4 py-2 text-left">Branch</TableHead>
                  <TableHead class="px-4 py-2 text-left">Password</TableHead>
                  <TableHead class="px-4 py-2 text-left">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="user in tableData" :key="user.id" class="border-b">
                  <TableCell class="px-4 py-2">{{ user.id }}</TableCell>
                  <TableCell class="px-4 py-2">{{ user.name }}</TableCell>
                  <TableCell class="px-4 py-2">{{ user.branch }}</TableCell>
                  <TableCell class="px-4 py-2">{{ user.password }}</TableCell>
                  <TableCell class="px-4 py-2">
                    <Button size="sm" variant="outline">Edit</Button>
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
