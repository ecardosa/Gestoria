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
                        <th>NIF</th>
                        <th>Tipus</th>
                        <th>Import</th>
                        <th>Data proposta</th>
                        <th>Data acceptació</th>
                        <th>Data inicial</th>
                        <th>Data final</th>
                        <th>Acceptada</th>
                        <th>Comentaris</th>
                        <th></th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="quota in $page.props.quotas" :key="quota.id">
                        <td></td>
                        <td>{{ quota.empresa.nomEmpresa }}</td>
                        <td>{{ quota.nif }}</td>
                        <td>{{ quota.tipo_quota.nombreTipo }}</td>
                        <td>{{ quota.importePropuesta }}</td>
                        <td>{{ quota.fechaPropuesta }}</td>
                        <td>{{ quota.fechaAceptacion }}</td>
                        <td>{{ quota.fechaInicial }}</td>
                        <td>{{ quota.fechaFinal }}</td>
                        <td>{{ quota.aceptada == 1 ? 'Sí' : 'No' }}</td>
                        <td>{{ quota.comentarios }}</td>
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