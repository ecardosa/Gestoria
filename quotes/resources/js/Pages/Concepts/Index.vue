<script setup>
import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombreConceptoCorto: '',
    nombreConceptoLargo: '',
    precio: '',
    idTipo: '',
});

const editState = ref({});

const showModalConcept = () => {
    form.nombreConceptoCorto = '';
    form.nombreConceptoLargo = '';
    form.precio = '';
    form.idTipo = '';
    editState.value['new'] = true;
};

const closeModal = (conceptId) => {
    delete editState.value[conceptId];
};
</script>

<template>
      <div class="bg-gray-100">
        <Header />
        <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 ml-10">
            <img src="/assets/img/triangulos.png" class="w-6">
       <h1 class="text-2xl font-semibold text-gray-900 mt-6 mb-4">
        Conceptes</h1>
    </div>
        <button class="btn btn-outline mr-10" @click="showModalConcept()">
            Afegir concepte
        </button>
    </div>
        <Modal :show="editState['new']" @close="closeModal('new')">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    + Afegir un nou concepte
                </h2>

                <form @submit.prevent="form.post(route('concepts.store')); closeModal('new')" class="mt-6 space-y-6">
                    <div>
                        <label for="nombreConceptoCorto" class="block text-sm font-medium text-gray-700">
                            Nom curt
                        </label>
                        <input id="nombreConceptoCorto" type="text" v-model="form.nombreConceptoCorto" class="mt-1 block
                            w-full" required autofocus autocomplete="nombreConceptoCorto" />
                    </div>

                    <div>
                        <label for="nombreConceptoLargo" class="block text-sm font-medium text-gray-700">
                            Nom llarg
                        </label>
                        <input id="nombreConceptoLargo" type="text" v-model="form.nombreConceptoLargo" class="mt-1 block

                            w-full" required autocomplete="nombreConceptoLargo" />
                    </div>

                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700">
                            Preu
                        </label>
                        <input id="precio" type="number" v-model="form.precio" class="mt-1 block w-full" required
                            autocomplete="precio" />
                    </div>

                    <div>
                        <label for="idTipo" class="block text-sm font-medium text-gray-700">
                            Tipus de concepte
                        </label>
                        <select id="idTipo" v-model="form.idTipo" class="mt-1 block w-full">
                            <option v-for="tipo in $page.props.conceptsTypes" :key="tipo.id" :value="tipo.id">
                                {{ tipo.nombreTipo }}
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
        </Modal>

        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom curt</th>
                        <th>Nom llarg</th>
                        <th>Preu</th>
                        <th>Tipus de concepte</th>
                        <th></th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="concept in $page.props.concepts" :key="concept.id">
                        <th></th>
                        <td>{{ concept.nombreConceptoCorto }}</td>
                        <td>{{ concept.nombreConceptoLargo }}</td>
                        <td>{{ concept.precio }}€</td>
                        <td>
                            <!-- {{ concept.tipo_concepto.nombreTipo  }} -->
                            <!-- if idTipo is null, "Sense tipus" -->
                            {{ concept.tipo_concepto ? concept.tipo_concepto.nombreTipo : 'Sense tipus' }}
                        </td>
                        <td class="text-right">
                            <!-- <button class="btn btn-outline" :value="user.id" @click="showModal(user)">
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
                            <Link :href="route('concepts.destroy', concept.id)" method="delete">
                            <button class="btn btn-outline">Eliminar</button>
                            </Link> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
</template>

<script setup></script>