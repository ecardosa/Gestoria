<script setup>
import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombreTipo: '',
});

const editState = ref({});

const showModalConceptType = () => {
    form.nombreTipo = '';
    editState.value['new'] = true;
};

const closeModal = (conceptTypeId) => {
    delete editState.value[conceptTypeId];
};


</script>

<template>
   <div class="bg-gray-100">
        <Header />
        <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 ml-10">
            <img src="/assets/img/triangulos.png" class="w-6">
       <h1 class="text-2xl font-semibold text-gray-900 mt-6 mb-4">
       Tipus de conceptes</h1>
    </div>
    <button class="btn btn-outline mr-10" @click="showModalConceptType()">
            + Afegir tipus
        </button>
    </div>
       
        <Modal :show="editState['new']" @close="closeModal('new')">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Afegir un nou tipus de concepte
                </h2>

                <form @submit.prevent="form.post(route('concepts-types.store')); closeModal('new')" class="mt-6 space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nom
                        </label>
                        <input id="name" type="text" v-model="form.nombreTipo" class="mt-1 block
                            w-full" required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-6">
                        <button class="btn" type="submit">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </Modal>


        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative" v-if="$page.props.conceptTypes.length > 0">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th class="text-right">
                            Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="conceptType in $page.props.conceptTypes" :key="conceptType.id">
                        <th>{{ conceptType.id }}</th>
                        <td>{{ conceptType.nombreTipo }}</td>
                        
                        <td class="text-right">
                             <Link :href="route('concepts-types.destroy', conceptType.id)" method="delete" >
                                <button class="btn">
                                    Eliminar
                                </button>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="h-screen" v-else>
            <div class="p-6 flex items-center justify-center flex-col space-y-4">
                <p class="text-gray-700">Encara no hi ha tipus de conceptes, afegeix un al botó!</p>
                <img src="/assets/img/none.png" class="w-1/4">
            </div>
            </div>
        </div>
</template>

<style scoped></style>