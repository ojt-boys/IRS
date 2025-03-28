<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black min-h-screen flex flex-col items-center justify-center relative">
        <!-- Navigation Bar -->
        <nav class="absolute top-6 right-10 flex space-x-4">
            <Link v-if="$page.props.auth.user" :href="route('admin.Dashboard')" class="text-black font-medium hover:underline">
                Dashboard
            </Link>
            <template v-else>
                <Link 
  :href="route('login')" 
  class="text-black font-bold text-lg md:text-xl lg:text-2xl tracking-wide hover:underline hover:text-gray-700 transition duration-300"
>
                    LOG IN
                </Link>
                <Link v-if="canRegister" :href="route('register')" class="text-black font-medium hover:underline">
                    Register
                </Link>
            </template>
        </nav>
        
        <!-- Logo and Title -->
        <div class="flex lg:justify-center lg:col-start-2">
            <AuthenticationCardLogo size="large" />

</div>


    </div>
</template>
