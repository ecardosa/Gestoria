<script setup>
import Header from '@/Components/Header.vue';
import { Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Search from '@/Components/Search.vue';

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
    name: '',
    idperfil: '',
});
</script>

<template>
    <div class="bg-gray-100 h-screen overflow-y-auto">
        <Header />
        <div class="sm:p-10 px-4 py-6 flex justify-between items-center space-x-4">
            <Search />
            <div class="w-[40px] h-[40px]">
            <button class="btn btn-square btn-outline w-[40px] min-h-[40px] h-[40px]" @click="showModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 rotate-45"
                fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>


        <Modal :show="editState" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Afegir una nova empresa
                </h2>

                <form  class="mt-6 space-y-6" @submit.prevent="form.post(route('companies.store')); closeModal()">
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
        </div>
        </div>
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-4 
            lg:grid-cols-3 md:grid-cols-2 mb-10 
            sm:grid-cols-1 sm:px-20 px-2 px-4 flex justify-center items-center w-full">
            <Link class="card w-auto bg-base-100 hover:shadow-md rounded-lg transition duration-300 ease-in-out"
                v-for="company in $page.props.companies" :key="company.id" :href="route('companies.show', company.id)">
            <div class="card-body p-4">
                <div class="flex p-1 gap-1 pb-4">
                    <div class="">
                        <span class="bg-blue-500 inline-block center w-3 h-3 rounded-full"></span>
                    </div>
                    <div class="circle">
                        <span class="bg-purple-500 inline-block center w-3 h-3 rounded-full"></span>
                    </div>
                    <div class="circle">
                        <span class="bg-pink-500 box inline-block center w-3 h-3 rounded-full"></span>
                    </div>
                </div>
                <h2 class="card-title">
                    {{ company.nomEmpresa }}
                </h2>
                
                <p>
                    {{ company.idperfil ? company.perfil.nomPerfil : 'Sense perfil' }}
                </p>
            </div>
            </Link>
        </div>
    </div>
</template>

<style scoped></style>