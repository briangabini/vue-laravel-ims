<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Order {
    id: number;
    order_number: string;
    total_amount: number;
    status: string;
    created_at: string;
    user: { name: string };
}

defineProps<{ orders: { data: Order[] } }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: '#',
    },
];
</script>

<template>
    <Head title="Manage Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Manage Orders</h1>

                    <div v-if="orders.data.length > 0" class="overflow-x-auto mt-4">
                        <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Order #</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Customer</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Total Amount</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Order Date</th>
                                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders.data" :key="order.id" class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                                        <Link :href="route('admin.orders.show', order.order_number)" class="block w-full h-full py-2 px-4">
                                            {{ order.order_number }}
                                        </Link>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                                        <Link :href="route('admin.orders.show', order.order_number)" class="block w-full h-full py-2 px-4">
                                            {{ order.user.name }}
                                        </Link>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                                        <Link :href="route('admin.orders.show', order.order_number)" class="block w-full h-full py-2 px-4">
                                            ${{ order.total_amount.toFixed(2) }}
                                        </Link>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                                        <Link :href="route('admin.orders.show', order.order_number)" class="block w-full h-full py-2 px-4">
                                            {{ order.status }}
                                        </Link>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                                        <Link :href="route('admin.orders.show', order.order_number)" class="block w-full h-full py-2 px-4">
                                            {{ new Date(order.created_at).toLocaleDateString() }}
                                        </Link>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-gray-100">
                                        <Link :href="route('admin.orders.edit', order.order_number)" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit Status</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center text-gray-500 dark:text-gray-400">
                        No orders found.
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
