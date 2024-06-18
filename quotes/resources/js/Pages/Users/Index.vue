<script setup>
import Header from '@/Components/Header.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const { props } = usePage();
const users = ref(props.users);
const activeTab = ref('all');

const filteredUsers = computed(() => {
    if (activeTab.value === 'all') {
        return users.value;
    } else if (activeTab.value === 'admins') {
        return users.value.filter(user => user.is_admin);
    } else if (activeTab.value === 'notActive') {
        return users.value.filter(user => !user.is_active);
    }
});

const form = useForm({
    name: '',
    email: '',
    idperfil: '',
    is_admin: false,
    is_active: false,
    password: '',
});

const editState = ref({});

const showModal = (user) => {
    form.name = user.name;
    form.email = user.email;
    form.idperfil = user.idperfil;
    form.is_admin = !!user.is_admin;
    form.is_active = !!user.is_active;
    editState.value[user.id] = true;
    console.log(form);
};

const showModalUser = () => {
    form.name = '';
    form.email = '';
    form.idperfil = '';
    form.is_admin = '';
    form.is_active = '';
    form.password = '';
    editState.value['new'] = true;
};

const closeModal = (userId) => {
    delete editState.value[userId];
};

const updateUser = async (userId) => {
    await form.put(route('users.update', userId));
    closeModal(userId);
    const updatedUser = users.value.find(user => user.id === userId);
    if (updatedUser) {
        updatedUser.name = form.name;
        updatedUser.email = form.email;
        updatedUser.idperfil = form.idperfil;
        updatedUser.is_admin = form.is_admin;
        updatedUser.is_active = form.is_active;
    }
};

const deleteUser = async (userId) => {
    await form.delete(route('users.destroy', userId));
    users.value = users.value.filter(user => user.id !== userId);
};

const AddUser = async () => {
    console.log(form, 'form');
    await form.post(route('users.store'));
    const registroentrada = [];
    console.log(form);
    const perfil = props.profiles.find(perfil => perfil.id === form.idperfil);
    users.value.push({ ...form, registroentrada, perfil });
    closeModal('new');
};
</script>

<template>
    <div class="bg-gray-100">
        <Header />
        <div class="flex items-center justify-between p-6 space-x-6">
            <div role="tablist" class="tabs tabs-bordered flex">
                <a role="tab" class="tab" :class="{ 'tab-active': activeTab === 'all' }" @click="activeTab = 'all'">
                    Tots els usuaris</a>
                <a role="tab" class="tab" :class="{ 'tab-active': activeTab === 'admins' }"
                    @click="activeTab = 'admins'">
                    Administradors</a>
                <a role="tab" class="tab" :class="{ 'tab-active': activeTab === 'notActive' }"
                    @click="activeTab = 'notActive'">
                    No donats d'alta</a>
            </div>
            <button class="btn btn-outline" @click="showModalUser()">
                Afegir usuari
            </button>

            <Modal :show="editState['new']" @close="closeModal('new')">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Afegir un nou usuari
                    </h2>

                    <form @submit.prevent="AddUser"
                     class="mt-6 space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nom
                            </label>
                            <input id="name" type="text" v-model="form.name" class="mt-1 block w-full" required
                                autofocus autocomplete="name" />
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Correu
                            </label>
                            <input id="email" type="email" v-model="form.email" class="mt-1 block w-full" required
                                autocomplete="email" />
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

                        <div class="flex flex-row justify-between">
                            <div>
                                <div class="form-control ">
                                    <label class="label cursor-pointer space-x-2">
                                        <input type="checkbox" class="checkbox" v-model="form.is_admin" />
                                        <span class="label-text
                                        ">Administrador</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <div class="form-control ">
                                    <label class="label cursor-pointer space-x-2">
                                        <input type="checkbox" class="checkbox" v-model="form.is_active" />
                                        <span class="label-text
                                        ">Dona't d'alta</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password
                            </label>
                            <input id="password" type="password" v-model="form.password" class="mt-1 block w-full"
                                required autocomplete="new-password" />
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


        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative"
            v-if="filteredUsers.length > 0">
            <table class="table ">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Correu</th>
                        <th>Perfil</th>
                        <th>Administrador</th>
                        <th>Dona't d'alta</th>
                        <th>Última entrada</th>
                        <th></th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in filteredUsers" :key="user.id">
                        <th></th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.perfil ? user.perfil.nomPerfil : 'Sense perfil' }}</td>
                        <td>{{ user.is_admin ? 'Sí' : 'No' }}</td>
                        <td>{{ user.is_active ? 'Sí' : 'No' }}</td>
                        <td>
                            {{ user.registroentrada.length ? user.registroentrada[0].fecha : 'Sense registre' }}
                        </td>
                        <td class="text-right">
                            <button class="btn btn-outline" :value="user.id" @click="showModal(user)">
                                Editar
                            </button>
                            <Modal :show="editState[user.id]" @close="closeModal(user.id)">
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        Editar usuari {{ user.name }}
                                    </h2>

                                    <form
                                        @submit.prevent="updateUser(user.id); closeModal(user.id);"
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

                                        <div class="flex flex-row justify-between">
                                            <div>
                                                <div class="form-control ">
                                                    <label class="label cursor-pointer space-x-2">
                                                        <input type="checkbox" class="checkbox"
                                                            v-model="form.is_admin"  />
                                                        <span class="label-text">Administrador</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="form-control ">
                                                    <label class="label cursor-pointer space-x-2">
                                                        <input type="checkbox" class="checkbox"
                                                            v-model="form.is_active"  />
                                                        <span class="label-text">Dona't d'alta</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-6">
                                            <button class="btn" type="submit">
                                                Guardar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </Modal>
                        </td>
                        <td> 
                            <button  @click="deleteUser(user.id)"
                            class="btn btn-outline">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded-lg shadow" v-else>
            No hi ha usuaris
        </div>
    </div>
</template>

<style scoped></style>
