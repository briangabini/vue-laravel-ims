<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import AppHeader from '@/components/AppHeader.vue';
import NavMain from '@/components/NavMain.vue';
import NavFooter from '@/components/NavFooter.vue';
</script>

<template>
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
