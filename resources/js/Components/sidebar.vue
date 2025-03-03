<script setup>
import { ref } from 'vue';
import { X, Menu, ChevronUp, ChevronDown } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';


const isOpen = ref(false);
const statusOpen = ref(false);
const links = ref([
  { name: "Dashboard", href: "/dashboard" },
  { name: "Incoming", href: "/incoming" },
  { name: "For Checking", href: "/ForChecking" },
  { 
    name: "Status", 
    children: [
      { name: "Repairing", href: "/Repairing" },
      { name: "Failed", href: "/Failed" }
    ] 
  },
  { name: "Refund", href: "/Refund" },
  { name: "Completed", href: "/Completed" },
  { name: "Payments", href: "/Payments" },
  { name: "Account", href: "/Account" }
]);

const toggleSidebar = () => {
  isOpen.value = !isOpen.value;
};

const toggleStatus = () => {
  statusOpen.value = !statusOpen.value;
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
  <div class="flex">
    <!-- Sidebar -->
    <transition name="slide">
      <aside 
        v-if="isOpen"
        class="w-64 h-screen bg-white text-black shadow-md flex flex-col fixed left-0 top-0 z-50 overflow-y-auto"
      >
        <!-- Sidebar Header -->
        <div class="p-5 flex items-center justify-between border-b border-gray-300">
          <img src="/LOGO.png" alt="Logo" class="h-28 w-auto mx-auto" />
          <button @click="toggleSidebar" class="p-2">
            <X class="w-6 h-6 text-black" />
          </button>
        </div>

        <!-- Sidebar Links (Scrollable) -->
        <nav class="flex-1 p-3 overflow-y-auto">
          <ul>
            <li v-for="link in links" :key="link.href">
              <div v-if="link.children">
                <!-- Status Item (Dropdown Toggle) -->
                <button 
                  class="flex justify-between items-center w-full text-lg font-bold uppercase p-3 rounded-lg hover:bg-gray-200 transition"
                  :class="{'bg-gray-300': statusOpen}"
                  @click="toggleStatus"
                >
                  <span>{{ link.name }}</span>
                  <component :is="statusOpen ? ChevronUp : ChevronDown" class="w-5 h-5" />
                </button>

                <!-- Animated Dropdown Items -->
                <transition name="dropdown">
                  <ul v-if="statusOpen" class="pl-5 mt-2 space-y-1">
                    <li v-for="child in link.children" :key="child.href">
                      <a 
                        :href="child.href" 
                        class="block text-md font-medium p-2 rounded-lg hover:bg-gray-200 transition"
                        :class="{'bg-gray-300': activeRoute === child.href}"
                      >
                        {{ child.name }}
                      </a>
                    </li>
                  </ul>
                </transition>
              </div>

              <!-- Regular Links -->
              <a 
                v-else
                :href="link.href" 
                class="block text-lg font-bold uppercase p-3 rounded-lg hover:bg-gray-200 transition"
                :class="{'bg-gray-300': activeRoute === link.href}"
              >
                {{ link.name }}
              </a>
            </li>
          </ul>
        </nav>

<!-- Logout Button -->
<div class="p-5 border-t border-gray-300">
  <button 
    @click.prevent="logout" 
    class="flex items-center gap-3 text-lg font-bold uppercase w-full p-3 hover:bg-gray-200 transition"
  >
    🚪 Log Out
  </button>
</div>

      </aside>
    </transition>

    <!-- Toggle Button (Menu Icon) -->
    <button 
      v-if="!isOpen" 
      @click="toggleSidebar"
      class="fixed top-5 left-5 bg-white text-black p-2 rounded-md shadow-md z-50"
    >
      <Menu class="w-6 h-6 text-black" />
    </button>

    <!-- Main Content -->
    <main class="flex-1 p-6 transition-all duration-300" :class="{'ml-64': isOpen}">
      <slot />
    </main>
  </div>
</template>

<style>
/* Ensure the sidebar scrolls properly */
aside {
  scrollbar-width: thin; /* Firefox */
  scrollbar-color: #ccc #f9f9f9; /* Firefox */
  overflow-y: auto;
  max-height: 100vh;
}

/* Webkit-based browsers (Chrome, Edge, Safari) */
aside::-webkit-scrollbar {
  width: 6px;
}

aside::-webkit-scrollbar-track {
  background: #f9f9f9;
}

aside::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}
</style>