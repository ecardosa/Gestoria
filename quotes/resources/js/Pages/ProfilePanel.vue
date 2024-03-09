<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';

const profiles = ref([]);


onMounted(() => {
    axios.get('/profile-panel/get-profile')
        .then(response => {
            profiles.value = response.data;
        });
});

function getProfile () {
    axios.get('/profile-panel/get-profile')
        .then(response => {
            profiles.value = response.data;
        });
}

const showModal = () => {
    const my_modal_1 = document.getElementById('my_modal_1');
    my_modal_1.showModal();
}

const closeModal = () => {
    const my_modal_1 = document.getElementById('my_modal_1');
    my_modal_1.close();
}

const form = useForm({
    nomPerfil: ''
});

const addProfile = () => {
    form.post('/profile-panel/add-profile', {
        onSuccess: () => {
            getProfile();
            closeModal();
        }
    });
}

// delete with confirmation
const deleteProfile = (id) => {
    if (confirm('Estàs segur que vols eliminar aquest perfil?')) {
        axios.delete('/profile-panel/delete-profile/' + id)
            .then(response => {
                getProfile();
            });
    }
}
</script>

<template>
    <div class="bg-gray-100">
        <Header />
        <button class="btn add-profile" @click="showModal">+ Afegir perfil</button>
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Afegir nou perfil</h3>
                <form method="post" action="/profile-panel/add-profile" @submit.prevent="addProfile">
                    <div class="form-control">
                        <label for="nomPerfil" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" id="nomPerfil" name="nomPerfil" v-model="form.nomPerfil" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="modal-action flex justify-center space-x-2">
                        <form method="dialog flex justify-center space-x-2">
                            <button class="btn btn-outline mr-2" type="submit" @click="addProfile">Afegir</button>
                            <button class="btn btn-outline ml-2">Tancar</button>
                        </form>
                    </div>
                </form>
            </div>
        </dialog>
        <div class="overflow-x-auto mt-16 bg-white">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="profile in profiles" :key="profile.id">
                        <th>{{ profile.id }}</th>
                        <td>{{ profile.nomPerfil }}</td>
                        <td class="flex justify-end space-x-2">
                            <button class="btn btn-outline" @click="deleteProfile(profile.id)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

.add-profile{
    position: absolute;
    right: 0;
    margin: 8px;
    background-color: black;
    color: rgb(252, 252, 252);
    transition: 0.3s;
}

.add-profile:hover {
    background-color: rgb(45, 45, 45);
    color: rgb(255, 255, 255);
}
</style>
