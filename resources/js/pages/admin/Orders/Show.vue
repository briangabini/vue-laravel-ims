<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    price: number;
}

interface OrderItem {
    id: number;
    quantity: number;
    price: number;
    product: Product;
}

interface Order {
    id: number;
    order_number: string;
    total_amount: number;
    status: string;
    created_at: string;
    user: { name: string; email: string };
    order_items: OrderItem[];
}

const props = defineProps<{ order: Order }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: route('admin.orders.index'),
    },
    {
        title: `Order #${props.order?.order_number || 'N/A'}`,
        href: '#',
    },
];
</script>

<template>
    <Head :title="`Order Details: #${order?.order_number || 'N/A'}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Order Details: #{{ order.order_number }}</h1>
                    <div class="mb-4">
                        <p class="text-gray-600 dark:text-gray-300"><strong>Customer:</strong> {{ order.user?.name || 'N/A' }} ({{ order.user?.email || 'N/A' }})</p>
                        <p class="text-gray-600 dark:text-gray-300"><strong>Total Amount:</strong> ${{ (order.total_amount || 0).toFixed(2) }}</p>
                        <p class="text-gray-600 dark:text-gray-300"><strong>Status:</strong> {{ order.status || 'N/A' }}</p>
                        <p class="text-gray-600 dark:text-gray-300"><strong>Order Date:</strong> {{ order.created_at ? new Date(order.created_at).toLocaleDateString() : 'N/A' }}</p>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Order Items</h2>
                    <div v-if="order.order_items.length > 0" class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Product</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Quantity</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Price</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in order.order_items" :key="item.id">
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ item.product.name }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ item.quantity }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">${{ (item.price || 0).toFixed(2) }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">${{ ((item.quantity || 0) * (item.price || 0)).toFixed(2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center text-gray-500 dark:text-gray-400">
                        No items in this order.
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
