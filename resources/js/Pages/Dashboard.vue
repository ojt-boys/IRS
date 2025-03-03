<template>
    <div class="flex">
      <!-- Sidebar -->
      <Sidebar />
  
      <!-- Main Content -->
      <div class="flex-1 p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <Card class="p-2 text-sm h-[350px] flex flex-col">
            <CardHeader>
              <CardTitle>Profit</CardTitle>
            </CardHeader>
            <CardContent class="h-[280px] flex items-center justify-center overflow-hidden">
              <BarChart :chart-data="profitData" :chart-options="chartOptions" />
            </CardContent>
          </Card>
    
          <Card class="p-2 text-sm h-[350px] flex flex-col">
            <CardHeader>
              <CardTitle>Earnings</CardTitle>
            </CardHeader>
            <CardContent class="h-[280px] flex items-center justify-center overflow-hidden">
              <LineChart :chart-data="earningsData" :chart-options="chartOptions" />
            </CardContent>
          </Card>
    
          <Card class="p-2 text-sm h-[350px] flex flex-col">
            <CardHeader>
              <CardTitle>Customers</CardTitle>
            </CardHeader>
            <CardContent class="h-[280px] flex items-center justify-center overflow-hidden">
              <PieChart :chart-data="customerData" :chart-options="chartOptions" />
            </CardContent>
          </Card>
        </div>
  
        <!-- Search Bar -->
        <div class="mt-6">
          <input type="text" placeholder="Search..." class="w-full p-2 border rounded-md" />
        </div>
    
        <!-- Table -->
        <div class="mt-4">
          <table class="w-full border-collapse border border-gray-300">
            <thead>
              <tr class="bg-gray-100">
                <th class="border p-2">ID</th>
                <th class="border p-2">Name</th>
                <th class="border p-2">Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in tableData" :key="index" class="text-center">
                <td class="border p-2">{{ item.id }}</td>
                <td class="border p-2">{{ item.name }}</td>
                <td class="border p-2">${{ item.amount }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
import { ref } from 'vue';
import { 
  Chart as ChartJS, 
  BarController, BarElement, 
  LineController, LineElement, PointElement, 
  PieController, ArcElement, 
  CategoryScale, LinearScale, 
  Tooltip, Legend 
} from 'chart.js';
import { BarChart, LineChart, PieChart } from 'vue-chart-3';
import Sidebar from "@/Components/sidebar.vue";
import Card from "@/Components/ui/Card.vue";
import CardHeader from "@/Components/ui/CardHeader.vue";
import CardTitle from "@/Components/ui/CardTitle.vue";
import CardContent from "@/Components/ui/CardContent.vue";

ChartJS.register(
  BarController, BarElement, 
  LineController, LineElement, PointElement, 
  PieController, ArcElement, 
  CategoryScale, LinearScale, 
  Tooltip, Legend
);

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false, 
  plugins: {
    legend: {
      position: 'top',
      labels: {
        boxWidth: 15
      }
    }
  },
  layout: {
    padding: 10
  }
});
  
const profitData = ref({
  labels: ['Jan', 'Feb', 'Mar'],
  datasets: [{
    label: 'Profit',
    data: [5000, 7000, 8000],
    backgroundColor: '#4CAF50'
  }]
});
  
const earningsData = ref({
  labels: ['Jan', 'Feb', 'Mar'],
  datasets: [{
    label: 'Earnings',
    data: [10000, 12000, 15000],
    borderColor: '#2196F3',
    fill: false
  }]
});
  
const customerData = ref({
  labels: ['New', 'Returning'],
  datasets: [{
    label: 'Customers',
    data: [60, 40],
    backgroundColor: ['#FF9800', '#FFC107']
  }]
});
  
const tableData = ref([
  { id: 1, name: 'Alice', amount: 500 },
  { id: 2, name: 'Bob', amount: 700 },
  { id: 3, name: 'Charlie', amount: 800 }
]);
</script>
