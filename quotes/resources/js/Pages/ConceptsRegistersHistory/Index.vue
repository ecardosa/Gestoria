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
                        <th>Perfil</th>
                        <th>Nom</th>
                        <th>Preu</th>
                        <th>Tipus</th>
                        <th></th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="register in $page.props.registers" :key="register.id">
                        <td></td>
                        <td>{{ register.empresa.nomEmpresa }}</td>
                        <td>{{ register.empresa.perfil.nomPerfil }}</td>
                        <td>{{ register.concepto.nombreConceptoCorto}}</td>
                        <td>{{ register.concepto.precio }}</td>
                        <td>{{ register.concepto.tipo_concepto.nombreTipo }}</td>
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