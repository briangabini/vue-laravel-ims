<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { router, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { computed, onMounted, ref, watch } from 'vue';
import { Input } from '@/components/ui/input';
import {
    RadioGroup,
    RadioGroupItem,
} from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';

interface Category {
    id: number;
    name: string;
}

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    category: Category; // Add category to Product interface
}

interface Props {
    products: Product[];
    categories: Category[];
    filters: { search?: string; category_id?: string };
}

const props = defineProps<Props>();

const page = usePage();
const lastLoginAttempt = computed(() => page.props.flash?.last_login_attempt);

onMounted(() => {
    if (lastLoginAttempt.value) {
        toast.success(
            `Your last login attempt was on ${lastLoginAttempt.value.logged_in_at} from ${lastLoginAttempt.value.ip_address}. It was ${lastLoginAttempt.value.successful ? 'successful' : 'unsuccessful'}.`,
            { duration: 5000 }
        );
    }
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category_id || '');

// Simple debounce function
const debounce = (fn: Function, delay: number) => {
    let timeoutId: ReturnType<typeof setTimeout>;
    return (...args: any[]) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
};

const applyFilters = debounce(() => {
    const params: { search?: string; category_id?: string } = {};

    if (search.value) {
        params.search = search.value;
    }

    if (selectedCategory.value) {
        params.category_id = selectedCategory.value;
    }

    console.log('Filtering with:', params);
    router.get(route('customers.home'), params, {
        preserveState: true,
        replace: true,
    });
}, 300); // Debounce for 300ms

watch([search, selectedCategory], () => {
    applyFilters();
});

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
    <AppLayout title="Home">
        <div class="container mx-auto py-8 flex">
            <!-- Sidebar for Filtering -->
            <div class="w-1/4 pr-8">
                <h2 class="text-xl font-bold mb-4">Filters</h2>

                <div class="mb-6">
                    <Label for="search">Search</Label>
                    <Input id="search" v-model="search" placeholder="Search products..." class="mt-1" />
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Categories</h3>
                    <RadioGroup v-model="selectedCategory">
                        <div class="flex items-center space-x-2 mb-2">
                            <RadioGroupItem id="all" value="" />
                            <Label for="all">All</Label>
                        </div>
                        <div v-for="category in categories" :key="category.id" class="flex items-center space-x-2 mb-2">
                            <RadioGroupItem :id="`category-${category.id}`" :value="category.id.toString()" />
                            <Label :for="`category-${category.id}`">{{ category.name }}</Label>
                        </div>
                    </RadioGroup>
                </div>
            </div>

            <!-- Product Listing -->
            <div class="w-3/4">
                <h1 class="text-2xl font-bold mb-6">Products</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="product in products" :key="product.id" class="border p-4 rounded-lg shadow-sm">
                        <img v-if="product.image" :src="`/storage/${product.image}`" alt="Product Image" class="w-full h-48 object-cover mb-4 rounded-md" />
                        <div v-else class="w-full h-48 bg-gray-200 flex items-center justify-center mb-4 rounded-md text-gray-500">
                            No Image
                        </div>
                        <h2 class="text-xl font-semibold mb-2">{{ product.name }}</h2>
                        <p class="text-sm text-muted-foreground">{{ product.category.name }}</p>
                        <p class="text-muted-foreground mb-4">{{ product.description }}</p>
                        <p class="text-lg font-bold mb-4">${{ product.price.toFixed(2) }}</p>
                        <p class="text-sm text-muted-foreground mb-4">Stock: {{ product.stock }}</p>
                        <Button @click="addToCart(product.id)">Add to Cart</Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
