<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    product_id: '',
    quantity: 1,
});

const products = ref([
    { id: 1, name: 'Product A', price: 10.00 },
    { id: 2, name: 'Product B', price: 20.00 },
    { id: 3, name: 'Product C', price: 30.00 },
]);

const submit = () => {
    form.post(route('customer.orders.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Place New Order" />

    <CustomerLayout>
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-6">Place New Order</h1>
            <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="product" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product</label>
                    <select id="product" v-model="form.product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="" disabled>Select a product</option>
                        <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }} - ${{ product.price.toFixed(2) }}</option>
                    </select>
                    <div v-if="form.errors.product_id" class="text-red-500 text-sm mt-1">{{ form.errors.product_id }}</div>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                    <input type="number" id="quantity" v-model.number="form.quantity" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                    <div v-if="form.errors.quantity" class="text-red-500 text-sm mt-1">{{ form.errors.quantity }}</div>
                </div>

                <button type="submit" :disabled="form.processing" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md">
                    Place Order
                </button>
            </form>
        </div>
    </CustomerLayout>
</template>
