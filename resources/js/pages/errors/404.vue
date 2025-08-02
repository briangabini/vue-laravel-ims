<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
</script>

<template>
    <Head title="Page Not Found" />

    <div class="flex items-center justify-center min-h-screen bg-background">
        <Card class="w-[400px]">
            <CardHeader class="text-center">
                <CardTitle class="text-6xl font-bold text-black dark:text-black">404</CardTitle>
                <CardDescription class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-4">Page Not Found</CardDescription>
            </CardHeader>
            <CardContent class="text-center">
                <p class="text-gray-600 dark:text-gray-400 mt-2">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                <Button class="mt-6">
                    <Link :href="route('customers.home')">
                        Return Home
                    </Link>
                </Button>
            </CardContent>
        </Card>
    </div>
</template>