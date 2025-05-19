<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppLogo from '@/components/AppLogo.vue';
import { computed } from 'vue';
import { SharedData } from '@/types';

const page = usePage<SharedData>();

const user = computed(() => page.props.auth.user);

</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <Link href="/" class="navbar-brand">
                <AppLogo />
            </Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <Link
                            :href="route('dashboard')"
                            :class="{ 'active': route().current('dashboard') }"
                            class="nav-link"
                        >
                            Главная
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            :href="route('history')"
                            :class="{ 'active': route().current('history') }"
                            class="nav-link"
                        >
                            История операций
                        </Link>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" class="d-flex text-dark align-items-center text-decoration-none dropdown-toggle" id="dropdownUser"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ user.login }}</span>
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                        <li>
                            <Link method="post" :href="route('logout')" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Выйти
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
