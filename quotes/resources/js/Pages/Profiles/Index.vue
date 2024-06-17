<script setup>
import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nomPerfil: '',
});

const editState = ref({});
const showModalProfile = () => {
    editState.value['new'] = true;
};

const closeModal = (id) => {
    editState.value[id] = false;
};



</script>

<template>
    <div class="bg-gray-100">
        <Header />
        <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 ml-10">
            <img src="/assets/img/triangulos.png" class="w-6">
       <h1 class="text-2xl font-semibold text-gray-900 mt-6 mb-4">
        Perfils</h1>
    </div>
        <button class="btn btn-outline mr-10" @click="showModalProfile()">
            + Afegir perfil
        </button>
    </div>
        <Modal :show="editState['new']" @close="closeModal('new')">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Afegir un nou perfil
                </h2>

                <form @submit.prevent="form.post(route('profiles.store')); closeModal('new')" class="mt-6 space-y-6">
                    <div>
                        <label for="nomPerfil" class="block text-sm font-medium text-gray-700">
                            Nom
                        </label>
                        <input id="nomPerfil" type="text" v-model="form.nomPerfil" class="mt-1 block w-full" required
                            autofocus autocomplete="nomPerfil" />
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
                        <th>Nom</th>
                        <th class="text-right pr-6">
                            Accions</th>
                     
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="profiles in $page.props.profiles" :key="profiles.id">
                        <th>
                            {{ profiles.id }}
                        </th>
                        <td>{{ profiles.nomPerfil }}</td>
                
                        <td class="text-right pr-6">
                       

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