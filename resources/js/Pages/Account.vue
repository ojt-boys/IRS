<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Button from '@/Components/ui/Button.vue';
import Modal from '@/Components/ui/Modal.vue'; // Import the modal component
import DefaultLayout from '@/Layouts/AppLayout.vue';

const users = ref([]);
const loading = ref(false);
const showModal = ref(false); // Control modal visibility

const newUser = ref({
  username: "",
  password: "",
  branch: "", // Now a text input instead of a dropdown
});

const fetchUsers = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/users');
    users.value = response.data;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
  loading.value = false;
};

const addUser = () => {
  showModal.value = true; // Show modal when button is clicked
};

const submitUser = async () => {
  try {
    await axios.post('/api/users', newUser.value);
    alert("User added successfully!");
    showModal.value = false;
    fetchUsers(); // Refresh user list
  } catch (error) {
    console.error("Error adding user:", error);
  }
};

onMounted(fetchUsers);
</script>

<template>
  <DefaultLayout>
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold">Manage Accounts</h2>
      <Button variant="primary" @click="addUser">+ Add User</Button>
    </div>

    <div v-if="loading" class="text-center my-4">
      <span class="text-gray-500">Loading...</span>
    </div>

    <table v-else class="table-auto w-full border-collapse border">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">ID</th>
          <th class="border p-2">Name</th>
          <th class="border p-2">Email</th>
          <th class="border p-2">Role</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="border p-2">{{ user.id }}</td>
          <td class="border p-2">{{ user.name }}</td>
          <td class="border p-2">{{ user.email }}</td>
          <td class="border p-2">{{ user.role }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Modal for Adding User -->
    <Modal :show="showModal" @close="showModal = false">
      <form @submit.prevent="submitUser">
        <div class="mb-3">
          <label class="block text-sm font-medium">Username</label>
          <input v-model="newUser.username" type="text" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium">Password</label>
          <input v-model="newUser.password" type="password" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium">Branch</label>
          <input v-model="newUser.branch" type="text" required class="w-full border p-2 rounded" placeholder="Enter branch name">
        </div>

        <div class="flex justify-end space-x-2 mt-4">
          <Button variant="secondary" @click="showModal = false">Cancel</Button>
          <Button variant="primary" type="submit">Save</Button>
        </div>
      </form>
    </Modal>
  </DefaultLayout>
</template>
