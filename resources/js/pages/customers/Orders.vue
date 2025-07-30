<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Link } from '@inertiajs/vue3';
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';

interface Order {
    id: number;
    order_number: string;
    status: string;
    total_price: number;
    created_at: string;
}

interface Props {
    orders: Order[];
}

defineProps<Props>();
</script>

<template>
    <AppLayout title="My Orders">
        <div class="container mx-auto py-4">
            <Breadcrumb>
                <BreadcrumbList>
                    <BreadcrumbItem>
                        <BreadcrumbLink :href="route('customers.home')">
                            Home
                        </BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbSeparator />
                    <BreadcrumbItem>
                        <BreadcrumbPage>My Orders</BreadcrumbPage>
                    </BreadcrumbItem>
                </BreadcrumbList>
            </Breadcrumb>
        </div>

        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6">My Orders</h1>

            <div v-if="orders.length > 0">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Order Number</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Total Price</TableHead>
                            <TableHead>Order Date</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="order in orders" :key="order.id">
                            <TableCell class="font-medium">{{ order.order_number }}</TableCell>
                            <TableCell>{{ order.status }}</TableCell>
                            <TableCell class="text-right">${{ order.total_price.toFixed(2) }}</TableCell>
                            <TableCell>{{ new Date(order.created_at).toLocaleDateString() }}</TableCell>
                            <TableCell>
                                <Link :href="route('my-orders.show', order.order_number)" class="text-blue-500 hover:underline">
                                    View Details
                                </Link>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <div v-else class="text-center text-muted-foreground">
                You have no orders yet.
            </div>
        </div>
    </AppLayout>
</template>
