<script setup>
import { ref, defineProps } from 'vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['company']);
console.log(props);
const editState = ref(false);

const showModal = () => {
    console.log('showModal');
    editState.value = true;
};

const closeModal = () => {
    console.log('closeModal');
    editState.value = false;
};

const form = useForm({
    name: props.company.nomEmpresa,
    idperfil: props.company.idperfil,
});

const submit = () => {
    form.patch(route('companies.update', props.company.id));
    closeModal();
};
</script>

<template>
    <button class="hover:bg-gray-400 rounded-full p-1" @click="showModal()">
        <img src="/assets/img/lapiz.svg" alt="Edit" class="w-4 h-4">
    </button>

    <Modal :show="editState" @close="closeModal()">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Editar {{ company.nomEmpresa }}
            </h2>

            <form class="mt-6 space-y-6"
                @submit.prevent="form.patch(route('companies.update', company.id)); closeModal()">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nom
                    </label>
                    <input id="name" type="text" v-model="form.name" class="mt-1 block w-full" required autofocus
                        autocomplete="name" />
                </div>

                <div>
                    <label for="nomPerfil" class="block text-sm font-medium text-gray-700">
                        Perfil
                    </label>
                    <select id="idperfil" v-model="form.idperfil" class="mt-1 block w-full">
                        <option v-for="perfil in $page.props.profiles" :key="perfil.id" :value="perfil.id">
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
    </Modal>
</template>