<script setup lang="ts">
import { ref } from "vue";
import { 
  Home, Inbox, CheckCircle, Search, 
  RotateCw, Package, ClipboardCheck, CreditCard, 
  User, LogOut, Wrench, XCircle 
} from "lucide-vue-next";
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

const activeItem = ref<string | null>(null);
const toggleSubmenu = (title: string) => {
  activeItem.value = activeItem.value === title ? null : title;
};

const items = [
  { title: "Dashboard", url: "#", icon: Home },
  { title: "Incoming", url: "#", icon: Inbox },
  { title: "For Checking", url: "#", icon: ClipboardCheck },
  { 
    title: "Status", icon: Search, 
    subItems: [
      { title: "Repairing", icon: Wrench, url: "#" },
      { title: "Failed", icon: XCircle, url: "#" },
    ]
  },
  { title: "Refund", url: "#", icon: RotateCw },
  { title: "For Return", url: "#", icon: Package },
  { title: "Completed", url: "#", icon: CheckCircle },
];

const accountItems = [
  { title: "Payments", url: "#", icon: CreditCard },
  { title: "Account", url: "#", icon: User },
];
</script>

<template>
  <AuthenticationCard>
    <Sidebar>
      <SidebarContent>
        <div class="flex flex-col h-full">
          <!-- LOGO SECTION -->
          <SidebarGroupLabel class="flex items-center justify-center py-6 border-b">
            <AuthenticationCardLogo class="max-w-[60%] h-auto" />
          </SidebarGroupLabel>
          
          <SidebarGroupContent class="flex-1 overflow-auto">
            <SidebarMenu>
              <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                  asChild
                  class="px-3 py-2 text-lg font-semibold text-gray-800 hover:bg-gray-100 rounded-lg"
                  @click="item.subItems ? toggleSubmenu(item.title) : null"
                >
                  <a :href="item.url" class="flex items-center gap-3">
                    <component :is="item.icon" class="w-5 h-5 text-gray-600" />
                    <span>{{ item.title }}</span>
                  </a>
                </SidebarMenuButton>
                <div v-if="item.subItems && activeItem === item.title" class="pl-6">
                  <SidebarMenuItem v-for="sub in item.subItems" :key="sub.title">
                    <SidebarMenuButton
                      asChild
                      class="px-3 py-2 text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg"
                    >
                      <a :href="sub.url" class="flex items-center gap-3">
                        <component :is="sub.icon" class="w-5 h-5 text-gray-500" />
                        <span>{{ sub.title }}</span>
                      </a>
                    </SidebarMenuButton>
                  </SidebarMenuItem>
                </div>
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
  
          <!-- Log Out Section (with extra space) -->
          <SidebarGroup class="mt-32 pb-4 border-t">
            <SidebarGroupContent>
              <SidebarMenu>
                <SidebarMenuItem>
                  <SidebarMenuButton
                    asChild
                    class="px-3 py-2 text-lg font-semibold text-red-600 hover:bg-gray-100 rounded-lg"
                  >
                    <a href="#" class="flex items-center gap-3">
                      <component :is="LogOut" class="w-5 h-5" />
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
  
