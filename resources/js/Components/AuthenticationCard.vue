<template>
    <div class="min-h-screen flex flex-col justify-center items-center">

        <!-- Card Container -->
        <div class="w-full sm:w-[400px] md:w-[500px] lg:w-[600px] p-8 bg-gray-900 text-white rounded-3xl shadow-2xl">
                    <!-- Logo Placeholder -->
        <div class="mb-8">
            <!-- You can place the logo component inside here -->
            <slot name="logo" />
        </div>
            <slot />
        </div>
    </div>
</template>
