<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { PlusCircle, MinusCircle } from 'lucide-vue-next';
import { computed } from 'vue';

interface User {
    id: number;
    name: string;
}

interface Product {
    id: number;
    name: string;
    price: number;
}

interface OrderItem {
    id?: number; // Optional for existing items
    product_id: number | string;
    quantity: number;
    price_per_unit: number;
}

interface Order {
    id: number;
    order_number: string;
    total_price: number;
    status: string;
    created_at: string;
    user_id: number;
    user: { name: string };
    order_items: OrderItem[];
}

const props = defineProps<{ order: Order; users: User[]; products: Product[] }>();

const form = useForm({
    user_id: props.order.user_id,
    status: props.order.status,
    total_price: props.order.total_price,
    order_items: props.order.order_items.map(item => ({
        id: item.id,
        product_id: item.product_id,
        quantity: item.quantity,
        price_per_unit: item.price_per_unit,
    })) as OrderItem[],
});

const addOrderItem = () => {
    form.order_items.push({
        product_id: '',
        quantity: 1,
        price_per_unit: 0,
    });
};

const removeOrderItem = (index: number) => {
    form.order_items.splice(index, 1);
};

const updateOrderItemPrice = (index: number) => {
    const selectedProduct = props.products.find(
        (p) => p.id === form.order_items[index].product_id
    );
    if (selectedProduct) {
        form.order_items[index].price_per_unit = selectedProduct.price;
    }
};

const submit = () => {
    form.put(route('admin.orders.update', props.order.order_number));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: route('admin.orders.index'),
    },
    {
        title: `Order #${props.order.order_number}`,
        href: route('admin.orders.show', props.order.order_number),
    },
    {
        title: 'Edit',
        href: '#',
    },
];

const totalOrderPrice = computed(() => {
    return form.order_items.reduce((sum, item) => {
        return sum + item.quantity * item.price_per_unit;
    }, 0);
});
</script>

<template>
    <Head :title="`Edit Order: #${order.order_number}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Edit Order: #{{ order.order_number }}</h1>
                    <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <Label for="user">Customer</Label>
                            <Select v-model="form.user_id">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a customer" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="" disabled>Select a customer</SelectItem>
                                    <SelectItem v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <div v-if="form.errors.user_id" class="text-red-500 text-sm mt-1">{{ form.errors.user_id }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="status">Status</Label>
                            <Select v-model="form.status">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="pending">Pending</SelectItem>
                                    <SelectItem value="processing">Processing</SelectItem>
                                    <SelectItem value="completed">Completed</SelectItem>
                                    <SelectItem value="cancelled">Cancelled</SelectItem>
                                </SelectContent>
                            </Select>
                            <div v-if="form.errors.status" class="text-red-500 text-sm mt-1">{{ form.errors.status }}</div>
                        </div>

                        <h2 class="text-xl font-semibold mb-3">Order Items</h2>
                        <div v-for="(item, index) in form.order_items" :key="index" class="mb-4 p-4 border rounded-md">
                            <div class="flex justify-end">
                                <Button type="button" variant="destructive" size="icon" @click="removeOrderItem(index)">
                                    <MinusCircle class="h-4 w-4" />
                                </Button>
                            </div>
                            <div class="mb-2">
                                <Label :for="`product-${index}`">Product</Label>
                                <Select v-model="item.product_id" @update:model-value="updateOrderItemPrice(index)">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select a product" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="" disabled>Select a product</SelectItem>
                                        <SelectItem v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</SelectItem>
                                    </SelectContent>
                                </Select>
                                <div v-if="form.errors[`order_items.${index}.product_id`]" class="text-red-500 text-sm mt-1">{{ form.errors[`order_items.${index}.product_id`] }}</div>
                            </div>
                            <div class="mb-2">
                                <Label :for="`quantity-${index}`">Quantity</Label>
                                <Input type="number" :id="`quantity-${index}`" v-model.number="item.quantity" min="1" max="99999" />
                                <div v-if="form.errors[`order_items.${index}.quantity`]" class="text-red-500 text-sm mt-1">{{ form.errors[`order_items.${index}.quantity`] }}</div>
                            </div>
                            <div class="mb-2">
                                <Label :for="`price_per_unit-${index}`">Price Per Unit</Label>
                                <Input type="number" :id="`price_per_unit-${index}`" v-model.number="item.price_per_unit" step="0.01" min="0" max="999999.99" />
                                <div v-if="form.errors[`order_items.${index}.price_per_unit`]" class="text-red-500 text-sm mt-1">{{ form.errors[`order_items.${index}.price_per_unit`] }}</div>
                            </div>
                        </div>

                        <Button type="button" variant="outline" @click="addOrderItem" class="mb-4">
                            <PlusCircle class="h-4 w-4 mr-2" /> Add Order Item
                        </Button>

                        <div class="mb-4 text-lg font-bold">
                            Total Price: ${{ totalOrderPrice.toFixed(2) }}
                        </div>

                        <Button type="submit" :disabled="form.processing">
                            Update Order
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
