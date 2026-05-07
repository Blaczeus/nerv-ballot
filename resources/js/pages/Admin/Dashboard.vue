<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <section class="flat-spacing">
            <div class="container">
                <h3 class="mb_8">Dashboard</h3>
                <p class="text-secondary">
                    Authenticated dashboard placeholder.
                </p>
            </div>
        </section>
    </AdminLayout>
</template>
