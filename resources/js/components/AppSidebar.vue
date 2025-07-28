<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    BookOpen, 
    LayoutGrid, 
    Settings, 
    DollarSign, 
    MessageCircle, 
    Home, 
    Plus, 
    UserCheck, 
    CreditCard,
    TrendingUp,
    Users,
    BarChart3
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();
const user = page.props.auth.user;

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'My Courses',
        href: '/courses',
        icon: BookOpen,
    },
    {
        title: 'Learning Progress',
        href: '/progress',
        icon: TrendingUp,
    },
    {
        title: 'Community',
        href: '/community',
        icon: Users,
    },
];

// Admin navigation items
const adminNavItems: NavItem[] = [
    {
        title: 'Admin Dashboard',
        href: '/admin',
        icon: LayoutGrid,
    },
    {
        title: 'Manage Courses',
        href: '/admin/courses',
        icon: BookOpen,
    },
    {
        title: 'Create Course',
        href: '/admin/courses/create',
        icon: Plus,
    },
    {
        title: 'User Management',
        href: '/admin/users',
        icon: UserCheck,
    },
    {
        title: 'Orders & Payments',
        href: '/admin/orders',
        icon: CreditCard,
    },
    {
        title: 'Analytics',
        href: '/admin/analytics',
        icon: BarChart3,
    },
];

// Public navigation items
const publicNavItems: NavItem[] = [
    {
        title: 'Home',
        href: '/',
        icon: Home,
    },
    {
        title: 'Courses',
        href: '/courses',
        icon: BookOpen,
    },
    {
        title: 'Pricing',
        href: '/pricing',
        icon: DollarSign,
    },
    {
        title: 'Contact',
        href: '/contact',
        icon: MessageCircle,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Settings',
        href: '/settings/profile',
        icon: Settings,
    },
    {
        title: 'Help & Support',
        href: '/support',
        icon: MessageCircle,
    },
];

// Determine which navigation items to show based on user role
const getNavItems = () => {
    if (user && (user as any).is_admin) {
        return [...mainNavItems, ...adminNavItems];
    } else if (user) {
        return mainNavItems;
    } else {
        return publicNavItems;
    }
};
</script>

<template>
    <Sidebar collapsible="icon" variant="inset" class="border-r border-gray-200 bg-white">
        <SidebarHeader class="border-b border-gray-200 bg-gradient-to-r from-teal-50 to-blue-50">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="hover:bg-gradient-to-r hover:from-teal-100 hover:to-blue-100">
                        <Link :href="user ? route('dashboard') : route('home')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="bg-white">
            <NavMain :items="getNavItems()" />
        </SidebarContent>

        <SidebarFooter class="border-t border-gray-200 bg-gray-50">
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
