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
                        <th>Nom</th>
                        <th></th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="profiles in $page.props.profiles" :key="profiles.id">
                        <th></th>
                        <td>{{ profiles.nomPerfil }}</td>
                        <td class="text-right">
                            <!-- <button class="btn" :value="user.id" @click="showModal(user)">
                                Editar
                            </button>
                            <Modal :show="editState[user.id]" @close="closeModal(user.id)">
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        Editar usuari {{ user.name }}
                                    </h2>

                                    <form
                                        @submit.prevent="form.patch(route('users.update', user.id)); closeModal(user.id)"
                                        class="mt-6 space-y-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">
                                                Nom
                                            </label>
                                            <input id="name" type="text" v-model="form.name" class="mt-1 block w-full"
                                                required autofocus autocomplete="name" />
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">
                                                Correu
                                            </label>
                                            <input id="email" type="email" v-model="form.email"
                                                class="mt-1 block w-full" required autocomplete="email" />
                                        </div>

                                        <div>
                                            <label for="nomPerfil" class="block text-sm font-medium text-gray-700">
                                                Perfil
                                            </label>
                                            <select id="idperfil" v-model="form.idperfil" class="mt-1 block w-full">
                                                <option v-for="perfil in $page.props.profiles" :key="perfil.id"
                                                    :value="perfil.id">
                                                    {{ perfil.nomPerfil }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mt-6">
                                            <button class="btn" type="submit">
                                                Guardar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </Modal> -->
                        </td>
                        <td>
                            <!-- <Link :href="route('users.destroy', user.id)" method="delete">
                            <button class="btn">Eliminar</button>
                            </Link> -->

                            <Link :href="route('profiles.destroy', profiles.id)" method="delete">
                                <button class="btn">Eliminar</button>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped></style>