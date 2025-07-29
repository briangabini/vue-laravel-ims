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
        <main>
            <slot />
        </main>
    </div>
</template>