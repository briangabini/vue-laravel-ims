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

interface Role {
    id: number;
    name: string;
}

defineProps<{ roles: Role[] }>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_id: '',
});

const submit = () => {
    form.post(route('admin.users.store'));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: route('admin.users.index'),
    },
    {
        title: 'Create',
        href: '#',
    },
];
</script>

<template>
    <Head title="Create User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-border">
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-4">Create New User</h1>
                    <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <Label for="name">Name</Label>
                            <Input type="text" id="name" v-model="form.name" />
                            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="email">Email</Label>
                            <Input type="email" id="email" v-model="form.email" />
                            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="password">Password</Label>
                            <Input type="password" id="password" v-model="form.password" />
                            <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="password_confirmation">Confirm Password</Label>
                            <Input type="password" id="password_confirmation" v-model="form.password_confirmation" />
                            <div v-if="form.errors.password_confirmation" class="text-red-500 text-sm mt-1">{{ form.errors.password_confirmation }}</div>
                        </div>

                        <div class="mb-4">
                            <Label for="role">Role</Label>
                            <Select v-model="form.role_id">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a role" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="placeholder" disabled>Select a role</SelectItem>
                                    <SelectItem v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <div v-if="form.errors.role_id" class="text-red-500 text-sm mt-1">{{ form.errors.role_id }}</div>
                        </div>

                        <Button type="submit" :disabled="form.processing">
                            Create User
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
