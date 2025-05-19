<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppHeader from '@/components/AppHeader.vue';
</script>

<template>
    <Head>
        <title>App</title>
    </Head>
    <AppHeader />
    <main class="container-lg mt-5">
        <slot />
    </main>
</template>
