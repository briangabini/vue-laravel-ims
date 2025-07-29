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
import { Button } from '@/components/ui/button';
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Product {
    id: number;
    name: string;
    price: number;
    stock: number;
}

interface CartItem {
    id: number;
    product: Product;
    quantity: number;
}

interface Props {
    cartItems: CartItem[];
}

const props = defineProps<Props>();

const cartTotal = computed(() => {
    return props.cartItems.reduce((sum, item) => sum + item.product.price * item.quantity, 0);
});

const updateQuantity = (cartItemId: number, newQuantity: number) => {
    if (newQuantity < 0) {
        return;
    }

    router.post(route('customers.cart.update'), {
        cart_item_id: cartItemId,
        quantity: newQuantity,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Cart updated successfully!');
        },
        onError: (errors) => {
            toast.error(errors.quantity || 'Failed to update cart.');
        },
    });
};

const removeItem = (cartItemId: number) => {
    router.delete(route('customers.cart.destroy'), {
        data: { cart_item_id: cartItemId },
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Item removed from cart!');
        },
        onError: () => {
            toast.error('Failed to remove item from cart.');
        },
    });
};
</script>

<template>
    <AppLayout>
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

            <div v-if="cartItems.length > 0">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Product</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead>Stock</TableHead>
                            <TableHead class="text-right">Price</TableHead>
                            <TableHead class="text-right">Subtotal</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in cartItems" :key="item.id">
                            <TableCell class="font-medium">{{ item.product.name }}</TableCell>
                            <TableCell>
                                <div class="flex items-center space-x-2">
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        @click="updateQuantity(item.id, item.quantity - 1)"
                                        :disabled="item.quantity <= 0"
                                    >
                                        -
                                    </Button>
                                    <span>{{ item.quantity }}</span>
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        @click="updateQuantity(item.id, item.quantity + 1)"
                                        :disabled="item.quantity >= item.product.stock"
                                    >
                                        +
                                    </Button>
                                </div>
                            </TableCell>
                            <TableCell>{{ item.product.stock }}</TableCell>
                            <TableCell class="text-right">${{ item.product.price.toFixed(2) }}</TableCell>
                            <TableCell class="text-right">${{ (item.product.price * item.quantity).toFixed(2) }}</TableCell>
                            <TableCell class="text-right">
                                <Button variant="destructive" size="sm" @click="removeItem(item.id)">
                                    Delete
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <div class="mt-4 text-right text-xl font-bold">
                    Total: ${{ cartTotal.toFixed(2) }}
                </div>
            </div>
            <div v-else class="text-center text-muted-foreground">
                Your cart is empty.
            </div>
        </div>
    </AppLayout>
</template>