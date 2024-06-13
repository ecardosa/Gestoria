<script setup>
import Header from '@/Components/Header.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Search from '@/Components/Search.vue'; // Importa tu componente del buscador

const { props } = usePage();
const users = ref(props.users);
console.log(users);
const profiles = ref(props.profiles);
console.log(profiles);

const form = useForm({
    name: '',
    email: '',
    idperfil: '',
    password: '',
});

const editState = ref({});

const showModal = (user) => {
    form.name = user.name;
    form.email = user.email;
    form.idperfil = user.idperfil;
    editState.value[user.id] = true;
};

const showModalUser = () => {
    form.name = '';
    form.email = '';
    form.idperfil = '';
    form.password = '';
    editState.value['new'] = true;
};

const closeModal = (userId) => {
    delete editState.value[userId];
};

const searchValue = ref('');

// Computed para filtrar los usuarios
// const filteredUsers = computed(() => {
//     if (!searchValue.value) {
//         return users.value;
//     }
//     return users.value.filter(user => {
//         const searchString = searchValue.value.toLowerCase();
//         return (
//             user.name.toLowerCase().includes(searchString) ||
//             user.email.toLowerCase().includes(searchString) ||
//             (user.perfil && user.perfil.nomPerfil.toLowerCase().includes(searchString)) ||
//             (user.registroentrada.length && user.registroentrada[0].fecha.toLowerCase().includes(searchString))
//         );
//     });
// });

</script>

<template>
    <div class="bg-gray-100">
        <Header />
        <div class="flex items-center justify-between p-6 space-x-6">
        <Search v-model="searchValue" />
        <button class="btn btn-outline" @click="showModalUser()">
            Afegir usuari
        </button>

        <Modal :show="editState['new']" @close="closeModal('new')">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Afegir un nou usuari
                </h2>

                <form @submit.prevent="form.post(route('users.store')); closeModal('new')" class="mt-6 space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nom
                        </label>
                        <input id="name" type="text" v-model="form.name" class="mt-1 block w-full" required autofocus
                            autocomplete="name" />
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
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input id="password" type="password" v-model="form.password" class="mt-1 block w-full" required
                            autocomplete="new-password" />
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
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="table ">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Correu</th>
                        <th>Perfil</th>
                        <th>Última entrada</th>
                        <th></th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in $page.props.users" :key="user.id"> 
                        <th></th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.perfil ? user.perfil.nomPerfil : 'Sense perfil' }}</td>
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
                            </Modal>
                        </td>
                        <td>
                            <Link :href="route('users.destroy', user.id)" method="delete">
                            <button class="btn btn-outline">Eliminar</button>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped></style>
