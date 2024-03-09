<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';

const companies = ref([]);
const profiles = ref([]);

onMounted(() => {
    axios.get('/companies-panel/get-companies')
        .then(response => {
            companies.value = response.data;
        });
});

function getCompanies () {
    axios.get('/companies-panel/get-companies')
        .then(response => {
            companies.value = response.data;
        });
}

onMounted(() => {
    axios.get('/profile-panel/get-profile')
        .then(response => {
            profiles.value = response.data;
        });
});


const showModal = () => {
    const my_modal_1 = document.getElementById('my_modal_1');
    my_modal_1.showModal();
}

const closeModal = () => {
    const my_modal_1 = document.getElementById('my_modal_1');
    my_modal_1.close();
}


const form = useForm({
    nomEmpresa: '',
    perfil: ''
});

const addCompany = () => {
    form.post('/companies-panel/add-company', {
        onSuccess: () => {
            getCompanies();
            closeModal();
        }
    });
}



</script>

<template>
    <div class="bg-gray-100">
        <Header />
        <button class="btn add-company" @click="showModal">+ Afegir empresa</button>
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Afegir nova empresa</h3>
               <!-- <form @submit.prevent="addCompany">
                    <div class="form-control">
                        <label for="nomEmpresa" class="label block text-sm font-medium text-gray-700">Nom de l'empresa</label>
                        <input type="text" id="nomEmpresa" v-model="form.nomEmpresa" class=" mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>
                    <div class="form-control">
                        <label for="perfil" class="label block text-sm font-medium text-gray-700">Perfil</label>
                        <select id="perfil" v-model="form.perfil" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md mb-5">
                            <option value="">Sense perfil</option>
                            <option v-for="profile in profiles" :key="profile.id" :value="profile.id">{{ profile.nomPerfil }}</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-outline">Afegir</button>
                        <button class="btn " @click="closeModal">Cancel·lar</button>
                    </div>
                </form>  -->
               
            </div>
        </dialog>
        <div class="overflow-x-auto mt-16 bg-white">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Perfil</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="company in companies" :key="company.id">
                        <td>{{ company.id }}</td>
                        <td>{{ company.nomEmpresa}}</td>
                        <td>{{ company.perfil ? company.perfil.nomPerfil : 'Sense perfil' }}</td>
                        <td class="flex justify-end space-x-2">
                            <button class="btn btn-outline">Editar</button>
                            <button class="btn btn-outline" @click="deleteCompany(company.id)">Eliminar</button>
                        </td>
                       
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
.add-company{
    position: absolute;
    right: 0;
    margin: 8px;
    background-color: black;
    color: rgb(252, 252, 252);
    transition: 0.3s;
}

.add-company:hover {
    background-color: rgb(45, 45, 45);
    color: rgb(255, 255, 255);
}
</style>
