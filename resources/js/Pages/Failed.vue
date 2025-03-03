<script setup>
import DefaultLayout from '@/Layouts/AppLayout.vue'; // Import the layout
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Button } from '@/Components/ui/button';

const shoes = ref([]);
const loading = ref(false);
const updating = ref({});

const fetchShoes = async () => {
  loading.value = true;
  // Fetch data logic here
  loading.value = false;
};

const markAsReceived = async (id) => {
  // Update status logic here
};

onMounted(fetchShoes);
</script>

<template>
  <DefaultLayout> <!-- Wrap the page inside the layout -->
    <h2 class="text-xl font-bold mb-4">Failed Shoes</h2>

    <div v-if="loading" class="text-center my-4">
      <span class="text-gray-500">Loading...</span>
    </div>

    <table v-else class="table-auto w-full border-collapse border">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">Name</th>
          <th class="border p-2">Quantity</th>
          <th class="border p-2">Supplier</th>
          <th class="border p-2">Status</th>
          <th class="border p-2">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="shoe in shoes" :key="shoe.id">
          <td class="border p-2">{{ shoe.shoe_name }}</td>
          <td class="border p-2 text-center">{{ shoe.quantity }}</td>
          <td class="border p-2">{{ shoe.supplier }}</td>
          <td class="border p-2">
            <span :class="shoe.status === 'Received' ? 'text-green-500' : 'text-yellow-500'">
              {{ shoe.status }}
            </span>
          </td>
          <td class="border p-2">
            <Button
              v-if="shoe.status === 'Pending'"
              :disabled="updating[shoe.id]"
              @click="markAsReceived(shoe.id)"
            >
              {{ updating[shoe.id] ? 'Processing...' : 'Received' }}
            </Button>
            <span v-else class="text-green-500">✔️ Received</span>
          </td>
        </tr>
      </tbody>
    </table>
  </DefaultLayout> <!-- Close the layout -->
</template>