<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/AuthLayout.vue';

const form = useForm({
    login: '',
    password: ''
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password')
    });
};
</script>


<template>
    <AuthLayout title="Войдите в свой аккаунт">
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="username" class="form-label">Логин</label>
                <input
                    type="text"
                    class="form-control"
                    id="username"
                    v-model="form.login"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="form.password"
                    required
                >
            </div>
            <button type="submit" class="btn btn-primary w-100">Войти</button>
        </form>
    </AuthLayout>
</template>
