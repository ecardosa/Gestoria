<script setup>
import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-gray-100">
        <Header />
        <div class="flex items-center space-x-2 ml-10">
            <img src="/assets/img/triangulos.png" class="w-6">
            <h1 class="text-2xl font-semibold text-gray-900 mt-6 mb-4">
                Històric de registres de conceptes
                </h1>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Empresa</th>
                        <th>Nom curt</th>
                        <th>Nom llarg</th>
                        <th>Preu</th>
                        <th>Tipus</th>
                        <th>Unitats</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="register in $page.props.registers" :key="register.id">
                        <td></td>
                        <td>
                            <Link :href="route('companies.show', register.idEmpresa)"
                                class="hover:underline hover:text-blue-500 transition duration-150 ease-in-out">
                            {{ register.nombreEmpresa }}
                            </Link>
                        </td>
                        <td>{{ register.nombreConceptoCorto }}</td>
                        <td>{{ register.nombreConceptoLargo }}</td>
                        <td>{{ register.precio }}</td>
                        <td>{{ register.nombreTipo }}</td>
                        <td>{{ register.unidades }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>