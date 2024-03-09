<script setup>
import Header from '@/Components/Header.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';

// get users
const users = ref([]);

onMounted(() => {
    getUsers();
});

function getUsers() {
    axios.get('/admin-panel/get-all-users')
        .then(response => {
            users.value = response.data;
        })
        .catch(error => {
            console.log(error);
        });
}


// modal
const showModal = (user) => {
    form.name = user.name;
    form.email = user.email;
    form.idperfil = user.idperfil;

    const modalId = 'my_modal_1' + user.id;
    const modal = document.getElementById(modalId); // Usar el ID dinámico
    modal.showModal();
};

const closeModal = (user) => {
    form.name = user.name;
    form.email = user.email;
    form.idperfil = user.idperfil;

    const modalId = 'my_modal_1' + user.id;
    const modal = document.getElementById(modalId); // Usar el ID dinámico
    modal.close();
};

const showModalAddUser = () => {
    const modal = document.getElementById('my_modal_1');
    modal.showModal();
};



// delete user
const deleteUser = (id, user) => {
    if (confirm('Estas segur que vols eliminar aquest usuari?')) {
        axios.delete('/admin-panel/delete/' + id)
            .then(response => {
                console.log(response.data);
                users.value = users.value.filter(user => user.id !== id);
                closeModal(user);

            })
            .catch(error => {
                console.log(error);
            });

    }
};

const form = useForm({
    name: '',
    email: '',
    idperfil: '',
});


// update user
const submit = (id, user) => {
    //   patch
    axios.patch('/admin-panel/update/' + id, form)
        .then(response => {
            console.log(response.data);
            users.value = users.value.map(user => {
                if (user.id === id) {
                    user.name = form.name;
                    user.email = form.email;
                    user.idperfil = form.idperfil;
                }
                return user;
            });
            getUsers();
            closeModal(user);
        })
        .catch(error => {
            console.log(error);
        });
};

const profiles = ref([]);
onMounted(() => {
    axios.get('/admin-panel/get-profiles')
        .then(response => {
            profiles.value = response.data;
        })
        .catch(error => {
            console.log(error);
        });
});

const formAdd = useForm({
    name: '',
    email: '',
    idperfil: '',
    password: '',
});

const submitAddUser = () => {
    axios.post('/admin-panel/add-user', formAdd)
        .then(response => {
            console.log(response.data);
            users.value.push(response.data);
            getUsers();
            const modal = document.getElementById('my_modal_1');
            modal.close();
        })
        .catch(error => {
            console.log(error);
        });
};


</script>

<template>

    <div class="bg-gray-100">
        <Header />
        <button class="btn add-users" @click="showModalAddUser">+ Afegir usuari</button>
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Afegir usuari nou</h3>
                <form @submit.prevent="submitAddUser" class="modal-form">
                    <div class="form-group">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" v-model="formAdd.name" required autofocus autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correu</label>
                        <input type="email" v-model="formAdd.email" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="idperfil" class="block text-sm font-medium text-gray-700">Perfil</label>
                        <select v-model="formAdd.idperfil" required class="select-profile">
                            <option v-for="profile in profiles" :key="profile.id" :value="profile.id">{{
            profile.nomPerfil }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contrasenya</label>
                        <input type="password" v-model="formAdd.password" required autocomplete="off">
                    </div>

                    <div class="modal-action">
                        <form method="dialog" class="add-users-buttons">
                            <button type="submit" @click="submitAddUser" class="btn save-add-user">Afegir</button>
                            <button class="btn cancel-add-user">Cancelar</button>
                        </form>
                    </div>
                </form>
            </div>
        </dialog>


        <div class="overflow-x-auto bg-white mt-16">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Correu</th>
                        <th>Perfil</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <th :value="user.id"> {{ user.id }} </th>
                        <td>{{ user.name }}</td>
                        <td> {{ user.email }} </td>
                        <td>{{ user.perfil ? user.perfil.nomPerfil : 'Sense perfil' }}</td>
                        <td class="flex justify-end space-x-2">
                            <button class="btn btn-outline" @click="showModal(user)" :value="user.id">Editar</button>
                            <dialog :id="'my_modal_1' + user.id" class="modal">
                                <div class="modal-box">
                                    <h3 class="font-bold text-lg header-modal">Editar usuari {{ user.id }}</h3>
                                    <form @submit.prevent="submit" class="modal-form">
                                        <div class="form-group">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700">Nom</label>
                                            <input type="text" v-model="form.name" required autofocus
                                                autocomplete="name" :placeholder="user.name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700">Correu</label>
                                            <input type="email" v-model="form.email" required autocomplete="email"
                                                :placeholder="user.email">
                                        </div>
                                        <div class="form-group">
                                            <label for="idperfil"
                                                class="block text-sm font-medium text-gray-700">Perfil</label>
                                            <select v-model="form.idperfil" required class="select-profile">
                                                <option v-for="profile in profiles" :key="profile.id"
                                                    :value="profile.id">{{ profile.nomPerfil }}</option>
                                            </select>
                                        </div>

                                    </form>
                                    <div class="modal-actions">
                                        <div>
                                            <button type="submit" class="btn m-2"
                                                @click="submit(user.id, user)">Guardar</button>
                                        </div>
                                        <form method="dialog">
                                            <button @click="closeModal(user)"
                                                class="btn px-4 py-2 rounded-lg m-2">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                                <form method="dialog" class="modal-backdrop">
                                    <button @click="closeModal(user)">Cancelar</button>
                                </form>
                            </dialog>
                        
                        
                            <button class="btn btn-outline" @click="deleteUser(user.id, user)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

.modal-box {
    display: flex !important;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.modal-form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.form-group {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    width: 100%;
}

.form-group input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.form-group label {

    text-align: left;
}

.modal-actions {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.select-profile {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.add-users {
    position: absolute;
    right: 0;
    margin: 8px;
    background-color: black;
    color: rgb(252, 252, 252);
    transition: 0.3s;
}

.add-users:hover {
    background-color: rgb(45, 45, 45);
    color: rgb(255, 255, 255);
}

.cancel-add-user{
    margin-left: 10px;
    background-color: black;
    color: rgb(252, 252, 252);
    transition: 0.3s;
}

.cancel-add-user:hover{
    background-color: rgb(45, 45, 45);
    color: rgb(255, 255, 255);
}

.save-add-user{
    margin-right: 10px;
    background-color: black;
    color: rgb(252, 252, 252);
    transition: 0.3s;
}

.save-add-user:hover{
    background-color: rgb(45, 45, 45);
    color: rgb(255, 255, 255);
}
</style>