<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Category {
    id: number;
    name: string;
    description: string;
}

const props = defineProps<{ category: Category }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: route('admin.categories.index'),
    },
    {
        title: props.category.name,
        href: '#',
    },
];
</script>

<template>
    <Head :title="category.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">{{ category.name }}</h1>
                    <div class="mb-4">
                        <p class="text-gray-600 dark:text-gray-300"><strong>Description:</strong> {{ category.description }}</p>
                    </div>
                    <Link :href="route('admin.categories.edit', category.id)" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md">Edit Category</Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
