<script setup lang="ts">
import { ref } from "vue";
import { 
  Home, Inbox, CheckCircle, Search, 
  RotateCw, Package, ClipboardCheck, CreditCard, 
  User, LogOut 
} from "lucide-vue-next";

import { Link, router } from '@inertiajs/vue3';  

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

const items = [
  { title: "Dashboard", url: "/admin/adminDashboard", icon: Home },
  { title: "Incoming", url: "/admin/adminIncoming", icon: Inbox },
  { title: "Assesment", url: "/admin/adminForchecking", icon: ClipboardCheck },
  { title: "Job Order", url: "/admin/adminStatus", icon: Search },
  { title: "Returned", url: "/admin/adminForreturn", icon: Package },
  { title: "Completed", url: "/admin/adminCompleted", icon: CheckCircle },
];

const accountItems = [
  { title: "Payments", url: "/admin/adminPayments", icon: CreditCard },
  { title: "Branch", url: "/admin/adminBranch", icon: User },
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

          <SidebarGroupContent class="flex-1 overflow-auto">
            <SidebarMenu>
              <SidebarMenuItem v-for="item in items" :key="item.title">
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

          <!-- Account Section -->
          <SidebarGroup class="pb-4 border-t">
            <SidebarGroupContent>
              <SidebarMenu>
                <SidebarMenuItem v-for="item in accountItems" :key="item.title">
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
          </SidebarGroup>

          <!-- Log Out Section -->
          <SidebarGroup class="mt-32 pb-4 border-t">
            <SidebarGroupContent>
              <SidebarMenu>
                <SidebarMenuItem>
                  <SidebarMenuButton
                    asChild
                    class="px-3 py-2 text-lg font-semibold text-red-600 hover:bg-gray-100 rounded-lg"
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
