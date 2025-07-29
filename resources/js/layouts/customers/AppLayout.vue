<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Button } from '@/components/ui/button';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { type BreadcrumbItem } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

defineProps<Props>();

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <nav class="bg-background border-b">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <Link :href="route('customers.home')">
                            <p class="font-bold">{{ $page.props.appName }}</p>
                        </Link>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Button variant="ghost" as-child>
                            <Link :href="route('customers.home')">
                                Home
                            </Link>
                        </Button>
                        <Button variant="ghost" as-child>
                            <Link :href="route('customers.cart')">
                                Cart
                            </Link>
                        </Button>
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Avatar>
                                    <AvatarImage src="https://github.com/radix-vue.png" alt="@radix-vue" />
                                    <AvatarFallback>CN</AvatarFallback>
                                </Avatar>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>My Account</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem as-child>
                                    <Link :href="route('customers.settings.profile')">Settings</Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem as-child>
                                    <Link :href="route('customers.orders')">Orders</Link>
                                </DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem @click="logout">
                                    Logout
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>
            </div>
        </nav>
        <div v-if="breadcrumbs && breadcrumbs.length > 0" class="flex w-full border-b border-sidebar-border/70">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
        <main>
            <slot />
        </main>
    </div>
</template>
