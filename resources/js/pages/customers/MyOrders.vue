<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';

interface Order {
    id: number;
    order_number: string;
    total_amount: number;
    status: string;
    created_at: string;
}

defineProps<{ orders: Order[] }>();
</script>

<template>
    <Head title="My Orders" />

    <CustomerLayout>
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-6">My Orders</h1>
            <div v-if="orders.length > 0" class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Order #</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Total Amount</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Status</th>
                            <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id">
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ order.order_number }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">${{ order.total_amount.toFixed(2) }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ order.status }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="text-center text-gray-500 dark:text-gray-400">
                You have no orders yet.
            </div>
        </div>
    </CustomerLayout>
</template>
