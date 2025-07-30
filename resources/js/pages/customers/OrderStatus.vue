<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';

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
    order?: Order; // Make order optional as it might not be present initially
    errors: Record<string, string>;
}

const props = defineProps<Props>();

const orderId = ref('');

// If an order is passed from the backend (e.g., after a redirect with order details)
if (props.order) {
    orderId.value = props.order.order_number;
}

const checkStatus = () => {
    if (!orderId.value) {
        toast.error('Please enter an Order ID.');
        return;
    }

    router.get(route('customers.order-status'), { order_number: orderId.value }, {
        preserveState: true,
        replace: true,
        onSuccess: () => {
            if (!props.order) {
                toast.error('Order not found.');
            }
        },
        onError: (errors) => {
            toast.error(errors.order_number || 'Failed to fetch order status.');
        },
    });
};

const formatTimestamp = (timestamp: string) => {
    return new Date(timestamp).toLocaleString();
};
</script>

<template>
    <AppLayout title="Order Status">
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
                        <BreadcrumbPage>Order Status</BreadcrumbPage>
                    </BreadcrumbItem>
                </BreadcrumbList>
            </Breadcrumb>
        </div>

        <div class="container mx-auto py-8">
            <div class="max-w-md mx-auto">
                <h1 class="text-2xl font-bold mb-4">Check Order Status</h1>
                <div class="flex space-x-2 mb-6">
                    <Input v-model="orderId" placeholder="Enter your order ID" @keyup.enter="checkStatus" />
                    <Button @click="checkStatus">Check Status</Button>
                </div>

                <div v-if="props.order">
                    <h2 class="text-xl font-bold mb-4">Order #{{ props.order.order_number }}</h2>
                    <div class="mb-6">
                        <p><strong>Status:</strong> {{ props.order.status }}</p>
                        <p><strong>Order Date:</strong> {{ formatTimestamp(props.order.created_at) }}</p>
                        <p><strong>Total Price:</strong> ${{ props.order.total_price.toFixed(2) }}</p>
                    </div>

                    <h3 class="text-lg font-bold mb-4">Items</h3>
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
                            <TableRow v-for="item in props.order.order_items" :key="item.id">
                                <TableCell class="font-medium">{{ item.product.name }}</TableCell>
                                <TableCell>{{ item.quantity }}</TableCell>
                                <TableCell class="text-right">${{ item.price_per_unit.toFixed(2) }}</TableCell>
                                <TableCell class="text-right">${{ (item.price_per_unit * item.quantity).toFixed(2) }}</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
                <div v-else-if="orderId && !props.order && !props.errors.order_number" class="text-center text-muted-foreground">
                    Order not found.
                </div>
                <div v-else-if="props.errors.order_number" class="text-center text-destructive">
                    {{ props.errors.order_number }}
                </div>
            </div>
        </div>
    </AppLayout>
</template>
