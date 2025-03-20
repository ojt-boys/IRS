<template>
    <form @submit.prevent="submit">
        <div>
            <label>Name</label>
            <input v-model="form.name" type="text" />
        </div>

        <div>
            <label>Email</label>
            <input v-model="form.email" type="email" />
        </div>

        <div>
            <label>Password</label>
            <input v-model="form.password" type="password" />
        </div>

        <div>
            <label>Role</label>
            <select v-model="form.role">
                <option value="super-admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="branch">Branch</option>
                <option value="shoe-technician">Technician</option>
            </select>
        </div>

        <button type="submit">Register</button>
    </form>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            role: 'branch' // Default role
        });

        const submit = () => {
            form.post('/register');
        };

        return { form, submit };
    }
};
</script>
