<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="h-screen bg-base-200 flex items-center justify-between flex-col">
    <div class="header text-right w-full p-2 ">
        <Link :href="route('logout')" method="post" as="button" class="btn btn-outline btn-square w-32">
            Tancar sessió</Link>
    </div>
    <div class="flex flex-col items-center justify-center h-full">
        <div>
            <h2 class="text-2xl font-bold text-center">
                La teva compta encara no està activa.
            </h2>
            <p class="text-center">
                T'avisarem quan estigui tot a punt!
            </p>
            <img src="/assets/img/notActive.png" alt="Not Active" class="mx-auto mt-8" width="300px">
        </div>
    </div>
</div>
</template>