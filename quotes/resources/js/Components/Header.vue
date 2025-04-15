<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

</script>

<template>
    <div>
        <div class=" bg-gray-100">
            <nav class="bg-black border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <Link href="/companies"
                            class="shrink-0 flex items-center">
                            <img src="/assets/img/logo.png" alt="Logo" class="h-16 w-auto" />
                            </Link>
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-white">
                                <NavLink :href="route('companies.index')" :active="route().current('companies.index')"
                                    class="text-white hover:text-orange-400">
                                    Empreses
                                </NavLink>
                                <div
                                    class="inline-flex items-center px-1  text-sm font-medium leading-5 text-gray-900 focus:outline-none  transition duration-150 ease-in-out">
                                    <Dropdown width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md bg-black">
                                                <button type="button"
                                                    class="inline-flex items-center py-2 border border-transparent text-sm leading-4 text-white font-medium rounded-md text-gray-500 bg-black hover:text-orange-400 focus:outline-none transition ease-in-out duration-150">
                                                    Conceptes

                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('concepts.index')"> Conceptes </DropdownLink>
                                            <DropdownLink :href="route('concepts-types.index')"> Tipus de conceptes
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                                <div
                                    class="inline-flex items-center px-1 text-sm pl-0 font-medium leading-5 text-gray-900 focus:outline-none  transition duration-150 ease-in-out">
                                    <Dropdown width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md bg-black">
                                                <button type="button"
                                                    class="inline-flex items-center py-2 border border-transparent text-sm leading-4 text-white font-medium rounded-md text-gray-500 bg-black hover:text-orange-400 focus:outline-none transition ease-in-out duration-150">
                                                    Històrics
                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('concepts-registers-history.index')">
                                                Històric de conceptes
                                            </DropdownLink>
                                            <DropdownLink :href="route('quotas-history.index')"> Històric de quotes
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6 bg-black">
                          
                            <div class="ms-3 relative ">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md bg-black">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 text-white font-medium rounded-md text-gray-500 bg-black hover:text-orange-400 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Perfil </DropdownLink>

                                        <DropdownLink :href="route('users.index')" v-if="$page.props.auth.user.is_admin">
                                            Panell d'usuaris 
                                        </DropdownLink>
                                        <DropdownLink :href="route('profiles.index')" v-if="$page.props.auth.user.is_admin"> Panell de perfils </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Tancar sessió
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Pàgina principal
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('companies.index')"
                            :active="route().current('companies.index')">
                            Empreses
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('concepts.index')" :active="route().current('concepts.index')">
                            Conceptes
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('concepts-types.index')"
                            :active="route().current('concepts-types.index')">
                            Tipus de conceptes
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('concepts-registers-history.index')"
                            :active="route().current('concepts-registers-history.index')">
                            Històric de conceptes
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('quotas-history.index')"
                            :active="route().current('quotas-history.index')">
                            Històric de quotes
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-white text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Perfil </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Tancar sessió
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
header {
    border-bottom: 1px solid #e2e8f0;
}
</style>