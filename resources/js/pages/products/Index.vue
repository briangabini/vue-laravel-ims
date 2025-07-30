<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    image: string;
}

defineProps<{ products: Product[] }>();
</script>

<template>
    <Head title="Products" />

    <CustomerLayout>
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-6">Our Products</h1>
            <div v-if="products.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div v-for="product in products" :key="product.id" class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <img :src="product.image_url" :alt="product.name" class="w-full h-48 object-cover" />
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ product.name }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ product.description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">${{ product.price.toFixed(2) }}</span>
                            <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center text-gray-500 dark:text-gray-400">
                No products available at the moment.
            </div>
        </div>
    </CustomerLayout>
</template>
