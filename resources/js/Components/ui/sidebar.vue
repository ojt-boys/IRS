<script setup>
import { ref } from 'vue';
import { Home, Users, Settings, Menu, X } from 'lucide-vue-next';
import { usePage, router } from '@inertiajs/vue3';

const links = [
  { name: "Dashboard", href: "/dashboard", icon: Home },
  { name: "Users", href: "/users", icon: Users },
  { name: "Settings", href: "/settings", icon: Settings }
];

const activeRoute = usePage().url;
const isOpen = ref(true); // Sidebar open/close state

const toggleSidebar = () => {
  isOpen.value = !isOpen.value;
};
</script>

<template>
  <div class="flex">
    <!-- Sidebar -->
    <transition name="slide">
      <aside 
        v-if="isOpen"
        class="w-64 h-screen bg-gray-900 text-white flex flex-col fixed left-0 top-0 z-50"
      >
        <div class="p-5 flex items-center justify-between">
          <span class="text-xl font-bold">My App</span>
          <button @click="toggleSidebar" class="text-white p-2">
            <X class="w-6 h-6" />
          </button>
        </div>
        <nav class="flex-1">
          <ul>
            <li v-for="link in links" :key="link.href">
              <a 
                :href="link.href" 
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700"
                :class="{'bg-gray-800': activeRoute === link.href}"
                @click.prevent="router.visit(link.href)"
              >
                <component :is="link.icon" class="w-5 h-5" />
                <span>{{ link.name }}</span>
              </a>
            </li>
          </ul>
        </nav>
      </aside>
    </transition>

    <!-- Toggle Button (Menu Icon) - Only shows when sidebar is hidden -->
    <button 
      v-if="!isOpen" 
      @click="toggleSidebar"
      class="fixed top-5 left-5 bg-gray-900 text-white p-2 rounded-md z-50"
    >
      <Menu class="w-6 h-6" />
    </button>

    <!-- Main Content -->
    <main class="flex-1 p-6 transition-all duration-300" :class="{'ml-64': isOpen}">
      <slot />
    </main>
  </div>
</template>

<style>
/* Sidebar Slide Animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  transform: translateX(-100%);
}
</style>
