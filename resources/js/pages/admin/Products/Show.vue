<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    quantity: number;
    category: { name: string };
}

const props = defineProps<{ product: Product }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('admin.products.index'),
    },
    {
        title: props.product.name,
        href: '#',
    },
];
</script>

<template>
    <Head :title="product.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">{{ product.name }}</h1>
                    <div class="mb-4">
                        <p class="text-gray-600 dark:text-gray-300"><strong>Description:</strong> {{ product.description }}</p>
                        <p class="text-gray-600 dark:text-gray-300"><strong>Category:</strong> {{ product.category.name }}</p>
                        <p class="text-gray-600 dark:text-gray-300"><strong>Price:</strong> ${{ product.price.toFixed(2) }}</p>
                        <p class="text-gray-600 dark:text-gray-300"><strong>Quantity:</strong> {{ product.quantity }}</p>
                    </div>
                    <Link :href="route('admin.products.edit', product.id)" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md">Edit Product</Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
