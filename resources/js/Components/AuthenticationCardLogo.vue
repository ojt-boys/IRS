<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <!-- Adjusted size without stretching or creating extra space -->
        <img src="../../assets/LOGO.png" alt="logo" class="h-32 max-w-full mx-auto invert object-contain" />
    </Link>
</template>
