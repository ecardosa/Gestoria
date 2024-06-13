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

        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative mt-16">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Empresa</th>
                        <th>Concepte</th>
                        <th>Unitats</th>
                        <th></th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="registre in $page.props.conceptsRegisters" :key="registre.id">
                        <th></th>
                        <td>{{ registre.empresa.nomEmpresa }}</td>
                        <td>{{ registre.concepto.nombreConceptoCorto }}</td>
                        <td>{{ registre.unidades }}</td>
                        <td>
                        </td>
                        <td class="text-right">
                            <button class="btn btn-outline">
                                Editar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>