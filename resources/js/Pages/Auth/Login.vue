<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
    
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-black text-white rounded-3xl shadow-lg p-8 w-96 text-center">
            <div class="flex justify-center mb-6 invert logo-size">
                <AuthenticationCardLogo size="medium" />

            </div>
            <form @submit.prevent="submit">
                <div class="text-left">
                    <InputLabel for="email" value="USERNAME :" class="text-white font-bold" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full rounded-lg bg-white text-black p-2"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2 text-red-500" :message="form.errors.email" />
                </div>

                <div class="mt-4 text-left">
                    <InputLabel for="password" value="PASSWORD :" class="text-white font-bold" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full rounded-lg bg-white text-black p-2"
                        required
                        autocomplete="current-password"
                    />
                    <InputError class="mt-2 text-red-500" :message="form.errors.password" />
                </div>

                <div class="text-sm mt-4">
                    <Link v-if="canResetPassword" :href="route('password.request')" class="text-gray-400 hover:underline">
                        FORGOT PASSWORD
                    </Link>
                </div>

                <div class="mt-6">
                    <PrimaryButton class="text-black font-bold p-3 rounded-lg text-center">
    LOG- IN
</PrimaryButton>

                </div>
            </form>
        </div>
    </div>
</template>