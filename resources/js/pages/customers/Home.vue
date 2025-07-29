<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
}

interface Props {
    products: Product[];
}

defineProps<Props>();

const addToCart = (productId: number) => {
    router.post(route('customers.cart.store'), { product_id: productId }, {
        onSuccess: () => {
            toast.success('Product added to cart successfully!');
        },
        onError: (errors) => {
            toast.error('Error adding product to cart.');
            console.error('Error adding to cart:', errors);
        },
    });
};
</script>

<template>
    <AppLayout>
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6">Products</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="product in products" :key="product.id" class="border p-4 rounded-lg shadow-sm">
                    <h2 class="text-xl font-semibold mb-2">{{ product.name }}</h2>
                    <p class="text-muted-foreground mb-4">{{ product.description }}</p>
                    <p class="text-lg font-bold mb-4">${{ product.price.toFixed(2) }}</p>
                    <p class="text-sm text-muted-foreground mb-4">Stock: {{ product.stock }}</p>
                    <Button @click="addToCart(product.id)">Add to Cart</Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
