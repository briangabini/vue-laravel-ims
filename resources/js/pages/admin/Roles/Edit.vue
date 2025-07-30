<script setup lang="ts">
import AppLayout from '@/layouts/admin/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

interface Role {
    id: number;
    name: string;
}

const props = defineProps<{ role: Role }>();

const form = useForm({
    name: props.role.name,
});

const submit = () => {
    form.put(route('admin.roles.update', props.role.id));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: route('admin.roles.index'),
    },
    {
        title: 'Edit',
        href: '#',
    },
];
</script>

<template>
    <Head :title="`Edit Role: ${role.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Edit Role: {{ role.name }}</h1>
                    <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <Label for="name">Role Name</Label>
                            <Input type="text" id="name" v-model="form.name" />
                            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <Button type="submit" :disabled="form.processing">
                            Update Role
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
