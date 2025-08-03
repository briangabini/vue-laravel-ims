<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Button } from '@/components/ui/button';

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    quantity: number;
    category_id: number;
    image_url: string;
}

interface Category {
    id: number;
    name: string;
}

const props = defineProps<{ product: Product; categories: Category[] }>();

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    quantity: props.product.quantity,
    category_id: props.product.category_id,
    image: null as File | null,
});

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
    }
};

const submit = () => {
    form.post(route('admin.products.update', props.product.id), {
        _method: 'put',
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('admin.products.index'),
    },
    {
        title: 'Edit',
        href: '#',
    },
];
</script>

<template>
    <Head :title="`Edit Product: ${product.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Edit Product: {{ product.name }}</h1>
                    <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <Label for="name">Product Name</Label>
                            <Input type="text" id="name" v-model="form.name" />
                            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="description">Description</Label>
                            <Textarea id="description" v-model="form.description" rows="3" />
                            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="price">Price</Label>
                            <Input type="number" id="price" v-model.number="form.price" step="0.01" min="0" max="999999.99" />
                            <div v-if="form.errors.price" class="text-red-500 text-sm mt-1">{{ form.errors.price }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="quantity">Quantity</Label>
                            <Input type="number" id="quantity" v-model.number="form.quantity" min="0" max="999999" />
                            <div v-if="form.errors.quantity" class="text-red-500 text-sm mt-1">{{ form.errors.quantity }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="category">Category</Label>
                            <Select v-model="form.category_id">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="" disabled>Select a category</SelectItem>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="image">Product Image</Label>
                            <Input type="file" id="image" @change="handleImageChange" accept="image/*" />
                            <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</div>
                            <div v-if="product.image_url" class="mt-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Current Image:</p>
                                <img :src="product.image_url" alt="Product Image" class="mt-1 w-32 h-32 object-cover rounded-md" />
                            </div>
                        </div>

                        <Button type="submit" :disabled="form.processing">
                            Update Product
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
