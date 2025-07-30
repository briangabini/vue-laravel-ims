<script setup lang="ts">
import AppLayout from '@/layouts/customers/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { router, usePage, Link } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { computed, onMounted, ref, reactive } from 'vue';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Label } from '@/components/ui/label';

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    category: Category; // Add category to Product interface
    image_url: string;
}

interface Props {
    products: {
        data: Product[];
        links: { url: string | null; label: string; active: boolean }[];
        current_page: number;
        last_page: number;
    };
    categories: Category[];
    filters: {
        category?: string;
        price_min?: number;
        price_max?: number;
        name?: string;
        sort_by?: string;
        sort_order?: string;
    };
}

const props = defineProps<Props>();

const page = usePage();
const lastLoginAttempt = computed(() => page.props.flash?.last_login_attempt);

onMounted(() => {
    if (lastLoginAttempt.value) {
        const ipAddress = lastLoginAttempt.value.ip_address || 'N/A';
        toast.success(
            `Your last login attempt was on ${lastLoginAttempt.value.logged_in_at} from ${ipAddress}. It was ${lastLoginAttempt.value.successful ? 'successful' : 'unsuccessful'}.`,
            { duration: 5000 }
        );
    }
});

const filterForm = reactive({
    category: props.filters.category === '' ? 'all' : props.filters.category || 'all',
    price_min: props.filters.price_min || null,
    price_max: props.filters.price_max || null,
    name: props.filters.name || '',
    sort_by: props.filters.sort_by || 'name',
    sort_order: props.filters.sort_order || 'asc',
});

const applyFilters = () => {
    const params = { ...filterForm };

    // Convert empty strings for number inputs to null so they are not included in the URL
    if (params.price_min === '') params.price_min = null;
    if (params.price_max === '') params.price_max = null;

    // Handle 'all' category value
    if (params.category === 'all') {
        params.category = '';
    }

    router.get(route('customers.home'), params, {
        preserveState: true,
        replace: true,
    });
};

const showImageDialog = ref(false);
const currentImageUrl = ref('');

const openImageDialog = (imageUrl: string) => {
    currentImageUrl.value = imageUrl;
    showImageDialog.value = true;
};

const closeImageDialog = () => {
    showImageDialog.value = false;
    currentImageUrl.value = '';
};

const resetFilters = () => {
    filterForm.category = 'all';
    filterForm.price_min = null;
    filterForm.price_max = null;
    filterForm.name = '';
    filterForm.sort_by = 'name';
    filterForm.sort_order = 'asc';
    applyFilters();
};

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
            <!-- Sidebar for Filtering and Sorting -->
            <div class="w-1/4 pr-8">
                <div class="mb-8"> <!-- Wrapper for Filters -->
                    <h2 class="text-xl font-bold mb-4">Filters</h2>
                    <form @submit.prevent="applyFilters" class="space-y-4">
                        <div>
                            <Label for="name">Product Name</Label>
                            <Input type="text" id="name" v-model="filterForm.name" placeholder="Search by name" class="mt-1" />
                        </div>
                        <div>
                            <Label for="category">Category</Label>
                            <Select v-model="filterForm.category">
                                <SelectTrigger class="w-full mt-1">
                                    <SelectValue placeholder="Select a category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">All Categories</SelectItem>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id.toString()">{{ category.name }}</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div>
                            <Label for="price_min">Min Price</Label>
                            <Input type="number" id="price_min" v-model="filterForm.price_min" placeholder="Minimum price" class="mt-1" min="0" />
                        </div>
                        <div>
                            <Label for="price_max">Max Price</Label>
                            <Input type="number" id="price_max" v-model="filterForm.price_max" placeholder="Maximum price" class="mt-1" min="0" />
                        </div>

                        <div class=""> <!-- Wrapper for Sort Options -->
                            <h2 class="text-xl font-bold mb-4">Sort By</h2>
                            <div class="space-y-4">
                                <div>
                                    <Label for="sort_by">Sort Field</Label>
                                    <Select v-model="filterForm.sort_by">
                                        <SelectTrigger class="w-full mt-1">
                                            <SelectValue placeholder="Sort by" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="name">Name</SelectItem>
                                            <SelectItem value="price">Price</SelectItem>
                                            <SelectItem value="stock">Stock</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                                <div>
                                    <Label for="sort_order">Sort Order</Label>
                                    <Select v-model="filterForm.sort_order">
                                        <SelectTrigger class="w-full mt-1">
                                            <SelectValue placeholder="Sort order" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="asc">Ascending</SelectItem>
                                            <SelectItem value="desc">Descending</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <Button type="button" variant="outline" @click="resetFilters">
                                Reset
                            </Button>
                            <Button type="submit">
                                Apply
                            </Button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Listing -->
            <div class="w-3/4">
                <h1 class="text-2xl font-bold mb-6">Products</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="product in products.data" :key="product.id" class="border p-4 rounded-lg shadow-sm flex flex-col">
                        <img :src="product.image_url" :alt="product.name" class="w-full h-48 object-cover mb-4 rounded-md cursor-pointer" @click="openImageDialog(product.image_url)" />
                        <h2 class="text-xl font-semibold mb-2">{{ product.name }}</h2>
                        <p class="text-sm text-muted-foreground">{{ product.category.name }}</p>
                        <p class="text-muted-foreground mb-4 flex-grow">{{ product.description }}</p>
                        <p class="text-lg font-bold mb-4">${{ product.price.toFixed(2) }}</p>
                        <p class="text-sm text-muted-foreground mb-4">Stock: {{ product.stock }}</p>
                        <Button @click="addToCart(product.id)" class="mt-auto">Add to Cart</Button>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="products.links.length > 3" class="flex justify-center mt-8 space-x-2">
                    <template v-for="link in products.links">
                        <Link
                            v-if="link.url"
                            :key="link.label"
                            :href="link.url"
                            :disabled="!link.url"
                            :preserve-scroll="true"
                            :replace="true"
                        >
                            <Button
                                :variant="link.active ? 'default' : 'outline'"
                                v-html="link.label"
                            />
                        </Link>
                        <Button
                            v-else
                            :key="link.label"
                            variant="outline"
                            disabled
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>

        <!-- Image Dialog -->
        <div v-if="showImageDialog" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50" @click.self="closeImageDialog">
            <div class="relative bg-white dark:bg-gray-800 p-4 rounded-lg max-w-3xl max-h-full overflow-auto">
                <button class="absolute top-2 right-2 text-gray-800 dark:text-white text-2xl font-bold" @click="closeImageDialog">&times;</button>
                <img :src="currentImageUrl" alt="Product Image" class="max-w-full max-h-[80vh] object-contain" />
            </div>
        </div>
    </AppLayout>
</template>
