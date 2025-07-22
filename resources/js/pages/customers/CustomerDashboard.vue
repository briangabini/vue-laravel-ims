<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Customer Dashboard" />

    <CustomerLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold">Welcome, Customer!</h1>
                    <p class="text-gray-600">This is your personalized dashboard.</p>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>