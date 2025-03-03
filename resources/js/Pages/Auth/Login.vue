<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <!-- Notification/Status message -->
        <div v-if="status" class="mb-4 text-lg font-bold text-green-600 dark:text-green-400 font-poppins">
            {{ status }}
        </div>

        <!-- Custom Logo Slot -->
        <template #logo>
            <div class="flex justify-center mb-8">
                <AuthenticationCardLogo />
            </div>
        </template>

        <!-- Form Container -->
        <form @submit.prevent="submit" class="p-6 md:p-8 font-poppins font-bold">
            <div class="flex flex-col gap-6">
                <!-- Email Input -->
                <div class="grid gap-2">
                    <InputLabel for="email" value="EMAIL" class="font-poppins font-bold tracking-wide" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full placeholder-gray-500 dark:placeholder-gray-400 font-poppins font-bold p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-gray-500"
                        placeholder="Enter your email"
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2 font-bold" :message="form.errors.email" />
                </div>

                <!-- Password Input -->
                <div class="grid gap-2">
                    <div class="flex items-center">
                        <InputLabel for="password" value="PASSWORD" class="font-poppins font-bold tracking-wide" />
                        <Link v-if="canResetPassword" :href="route('password.request')" class="ml-auto text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            Forgot your password?
                        </Link>
                    </div>
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full placeholder-gray-500 dark:placeholder-gray-400 font-poppins font-bold p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-gray-500" 
                        placeholder="Enter your password" 
                        autocomplete="current-password"
                    />
                    <InputError class="mt-2 font-bold" :message="form.errors.password" />
                </div>

                <!-- Remember Me Checkbox -->
                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox v-model:checked="form.remember" name="remember" />
                        <span class="ms-2 text-sm font-bold text-gray-600 dark:text-gray-400 font-poppins">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <PrimaryButton 
    class="flex justify-center mb-8 text-xl font-bold uppercase p-4 rounded-lg hover:bg-gray-200 transition font-orbitron bg-gray-900 text-white" 
    :class="{ 'opacity-25': form.processing }" 
    :disabled="form.processing">
    Log in
</PrimaryButton>


                <!-- Sign up link -->
                <div class="text-center text-sm mt-4 text-gray-400 font-poppins font-bold">
                    Don't have an account? <Link :href="route('register')" class="underline font-bold">Sign up</Link>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>
