<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Toaster } from '@/components/ui/sonner';
import AppHeader from '@/components/AppHeader.vue';
import NavMain from '@/components/NavMain.vue';
import NavFooter from '@/components/NavFooter.vue';

defineProps<{ title?: string }>();
</script>

<template>
    <Head :title="title ? `${title} - QuantumGrid` : 'QuantumGrid'" />
    <Toaster />
    <div class="min-h-screen flex flex-col">
        <AppHeader>
            <template #navigation>
                <NavMain />
            </template>
        </AppHeader>
        <main class="flex-grow container mx-auto p-4">
            <slot />
        </main>
        <NavFooter />
    </div>
</template>
