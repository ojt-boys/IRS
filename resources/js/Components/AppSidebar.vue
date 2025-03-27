<script setup lang="ts">
import { ref, onMounted } from "vue";
import { 
  Home, Inbox, CheckCircle, Search, 
  RotateCw, Package, ClipboardCheck, CreditCard, 
  User, LogOut 
} from "lucide-vue-next";

import { Link, router, usePage } from '@inertiajs/vue3';  

import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupLabel,
  SidebarGroupContent,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/Components/ui/sidebar";
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';

// ✅ Fetch roles from Inertia page props
const roles = ref<string[]>([]);

onMounted(() => {
  const page = usePage();
  roles.value = page.props.roles || [];
});

// ✅ Helper function to check roles
const hasRole = (role: string) => roles.value.includes(role);

const adminItems = [
  { title: "Dashboard", url: "/admin/Dashboard", icon: Home },
  { title: "Incoming", url: "/admin/Incoming", icon: Inbox },
  { title: "Assessment", url: "/admin/Assessment", icon: ClipboardCheck },
  { title: "Job Order", url: "/admin/Joborder", icon: Search },
  { title: "Returned", url: "/admin/Returned", icon: Package },
  { title: "Completed", url: "/admin/Completed", icon: CheckCircle },
  { title: "Payments", url: "/admin/Payments", icon: CreditCard },
  { title: "Users", url: "/admin/Users", icon: User },
];

const branchItems = [
  { title: "Add Shoes", url: "/branch/Addshoes", icon: Inbox },
  { title: "Shipped Shoes", url: "/branch/Shippedshoes", icon: ClipboardCheck },
];

const logout = () => {
  router.post('/logout');
};
</script>

<template>
  <AuthenticationCard>
    <Sidebar>
      <SidebarContent>
        <div class="flex flex-col h-full">
          <!-- LOGO SECTION -->
          <SidebarGroupLabel class="flex items-center justify-center h-20 border-b bg-white dark:bg-gray-800">
            <div class="w-full flex justify-center">
              <AuthenticationCardLogo class="max-w-[70%] h-auto mx-auto" />
            </div>
          </SidebarGroupLabel>

          <!-- Admin Sidebar -->
          <SidebarGroupContent v-if="hasRole('super-admin') || hasRole('admin')">
            <SidebarMenu>
              <SidebarMenuItem v-for="item in adminItems" :key="item.title">
                <SidebarMenuButton
                  asChild
                  class="px-3 py-2 text-lg font-semibold text-gray-800 hover:bg-gray-100 rounded-lg"
                >
                  <a :href="item.url" class="flex items-center gap-3">
                    <component :is="item.icon" class="w-5 h-5 text-gray-600" />
                    <span>{{ item.title }}</span>
                  </a>
                </SidebarMenuButton>
              </SidebarMenuItem>
            </SidebarMenu>
          </SidebarGroupContent>

          <!-- Branch Sidebar -->
          <SidebarGroupContent v-if="hasRole('branch')">
            <SidebarMenu>
              <SidebarMenuItem v-for="item in branchItems" :key="item.title">
                <SidebarMenuButton
                  asChild
                  class="px-3 py-2 text-lg font-semibold text-gray-800 hover:bg-gray-100 rounded-lg"
                >
                  <a :href="item.url" class="flex items-center gap-3">
                    <component :is="item.icon" class="w-5 h-5 text-gray-600" />
                    <span>{{ item.title }}</span>
                  </a>
                </SidebarMenuButton>
              </SidebarMenuItem>
            </SidebarMenu>
          </SidebarGroupContent>

          <!-- Log Out Section -->
          <SidebarGroup class="mt-32 pb-4 border-t">
            <SidebarGroupContent>
              <SidebarMenu>
                <SidebarMenuItem>
                  <SidebarMenuButton
                    asChild
                    class="px-3 py-2 text-lg font-semibold text-red-600 hover:bg-gray-100 rounded-lg text-red-600"
                  >
                    <a class="flex items-center gap-3" @click="logout">
                      <LogOut class="w-5 h-5" />
                      <span>Log Out</span>
                    </a>
                  </SidebarMenuButton>
                </SidebarMenuItem>
              </SidebarMenu>
            </SidebarGroupContent>
          </SidebarGroup>
        </div>
      </SidebarContent>
    </Sidebar>
  </AuthenticationCard>
</template>