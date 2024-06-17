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
                Històric de quotes
            </h1>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Quota</th>
                        <th>Empresa</th>
                        <th>NIF</th>
                        <th>Tipus</th>
                        <th>Import</th>
                        <th>Data proposta</th>
                        <th>Data acceptació</th>
                        <th>Data inicial</th>
                        <th>Data final</th>
                        <th>Acceptada</th>
                        <th>Comentaris</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="history in $page.props.quotasHistory" :key="history.id">
                        <td></td>
                        <td>{{ history.idQuota }}</td>
                        <td>{{ history.nombreEmpresa }}</td>
                        <td>{{ history.nif }}</td>
                        <td>{{ history.nombreTipoQuota }}</td>
                        <td>{{ history.importePropuesta }}</td>
                        <td>{{ history.fechaPropuesta }}</td>
                        <td>{{ history.fechaAceptacion }}</td>
                        <td>{{ history.fechaInicial }}</td>
                        <td>{{ history.fechaFinal }}</td>
                        <td>{{ history.aceptada == 1 ? 'Sí' : 'No' }}</td>
                        <td>{{ history.comentarios }}</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>