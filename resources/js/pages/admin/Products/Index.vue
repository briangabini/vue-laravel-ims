<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    quantity: number;
    category: { name: string };
}

defineProps<{ products: { data: Product[] } }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '#',
    },
];

const page = usePage();
const user = computed(() => page.props.auth.user);

const canDeleteProduct = computed(() => {
    return user.value && user.value.role.name === 'admin';
});

const deleteProduct = (id: number) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(route('admin.products.destroy', id));
    }
};
</script>

<template>
    <Head title="Manage Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Manage Products</h1>
                    <Link :href="route('admin.products.create')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md mb-4 inline-block">Create New Product</Link>

                    <div v-if="products.data.length > 0" class="overflow-x-auto mt-4">
                        <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">ID</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Name</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Category</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Price</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Quantity</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products.data" :key="product.id">
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ product.id }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ product.name }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ product.category.name }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">${{ product.price.toFixed(2) }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ product.quantity }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                                        <Link :href="route('admin.products.edit', product.id)" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</Link>
                                        <button v-if="canDeleteProduct" @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center text-gray-500 dark:text-gray-400">
                        No products found.
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
