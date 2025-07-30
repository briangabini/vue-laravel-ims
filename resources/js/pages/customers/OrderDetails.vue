<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { type BreadcrumbItem } from '@/types';
import { computed } from 'vue';

interface Product {
    id: number;
    name: string;
    price: number;
}

interface OrderItem {
    id: number;
    product: Product;
    quantity: number;
    price_per_unit: number;
}

interface Order {
    id: number;
    order_number: string;
    status: string;
    total_price: number;
    created_at: string;
    order_items: OrderItem[];
}

interface Props {
    order: Order | null; // Make order prop nullable
}

defineProps<Props>();

const formatTimestamp = (timestamp: string) => {
    return new Date(timestamp).toLocaleString();
};

const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    if (!props.order) {
        return [
            {
                title: 'My Orders',
                href: route('customers.orders'),
            },
        ];
    }
    return [
        {
            title: 'My Orders',
            href: route('customers.orders'),
        },
        {
            title: `Order #${props.order.order_number}`,
            href: route('my-orders.show', props.order.order_number),
        },
    ];
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="order ? `Order #${order.order_number}` : 'Order Details'" />

        <div v-if="order" class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6">Order #{{ order.order_number }}</h1>

            <div class="mb-6">
                <p><strong>Status:</strong> {{ order.status }}</p>
                <p><strong>Order Date:</strong> {{ formatTimestamp(order.created_at) }}</p>
                <p><strong>Total Price:</strong> ${{ order.total_price.toFixed(2) }}</p>
            </div>

            <h2 class="text-xl font-bold mb-4">Order Items</h2>
            <div v-if="order.order_items && order.order_items.length > 0">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Product</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead class="text-right">Price Per Unit</TableHead>
                            <TableHead class="text-right">Subtotal</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in order.order_items" :key="item.id">
                            <TableCell class="font-medium">{{ item.product.name }}</TableCell>
                            <TableCell>{{ item.quantity }}</TableCell>
                            <TableCell class="text-right">${{ item.price_per_unit.toFixed(2) }}</TableCell>
                            <TableCell class="text-right">${{ (item.price_per_unit * item.quantity).toFixed(2) }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <div v-else class="text-center text-muted-foreground">
                No items found for this order.
            </div>
        </div>
        <div v-else class="container mx-auto py-8 text-center text-muted-foreground">
            Order not found or not accessible.
        </div>
    </AppLayout>
</template>