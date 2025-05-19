<script setup lang="ts">

import { Head } from '@inertiajs/vue3';

defineProps<{
    title?: string;
}>();
</script>

<template>
    <Head>
        <title>Auth</title>
    </Head>
    <div class="auth-layout bg-light min-vh-100">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center mb-4">
                        <p class="text-muted">{{ title }}</p>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body p-4 p-sm-5">
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.auth-layout {
    background-color: #f8f9fa;
}
</style>
