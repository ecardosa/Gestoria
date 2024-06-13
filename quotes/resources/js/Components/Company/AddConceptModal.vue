<script setup>
import Dropdown from '../Dropdown.vue';
import DropdownLink from '../DropdownLink.vue';
import Modal from '../Modal.vue';
import { computed, ref, onMounted } from 'vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';

const { props } = usePage();

const editState = ref(false);
const showNou = ref(false);
const showExistent = ref(false);
const companyId = ref(props.company.id);
const concepts = ref(props.concepts);
const company = ref(props.company);

const showNewConcept = () => {
    showNou.value = true;
    showExistent.value = false;
    editState.value = true;
};

const showExistentConcept = () => {
    showNou.value = false;
    showExistent.value = true;
    editState.value = true;
};

const closeModal = () => {
    editState.value = false;
};

const form = useForm({
    companyId: companyId.value,
    name: '',
    namelong: '',
    type_id: '',
    price: '',
    unity: '',
});

const formExistent = useForm({
    companyId: companyId.value,
    concept_id: '',
    unity_existent: ''
});

const submitExistentConcept = (concept, unidades) => {
    
};
</script>

<template>
    <div>
        <div class="dropdown dropdown-end" @click.stop>
            <button class="btn btn-circle btn-outline w-[20px] min-h-[20px] h-[20px] place-self-center pl-1 pr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[12px] w-[12px] rotate-45 ml-[1px] mb-[1px]"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <li class="focus:bg-orange-500">
                    <a class="focus:bg-orange-500" @click="showNewConcept">
                        Afegir nou concepte
                    </a>
                </li>
                <li class="focus:bg-orange-500">
                    <a class="focus:bg-orange-500" @click="showExistentConcept">
                        Afegir concepte existent
                    </a>
                </li>
            </ul>
        </div>

        <Modal :show="editState" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-6">
                    Afegir concepte a {{ company.nomEmpresa }}
                </h2>

                <div v-if="showNou" class="nou">
                    <form class="mt-6 space-y-6" @submit.prevent="form.post(route('concepts-registers.store')), closeModal()">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nom Curt
                            </label>
                            <input v-model="form.name" id="name" type="text" class="mt-1 block w-full" required
                                autofocus autocomplete="name" />

                            <label for="namelong" class="block text-sm font-medium text-gray-700">
                                Nom Llarg
                            </label>
                            <input v-model="form.namelong" id="namelong" type="text" class="mt-1 block w-full" required
                                autofocus autocomplete="name" />

                            <label for="type_id" class="block text-sm font-medium text-gray-700">
                                Tipus de concepte
                            </label>
                            <select v-model="form.type_id" id="type_id" name="type_id" class="mt-1 block w-full">
                                <option value="">Selecciona un tipus</option>
                                <option v-for="type in $page.props.conceptType" :key="type.id" :value="type.id">
                                    {{ type.nombreTipo }}
                                </option>
                            </select>

                            <label for="price" class="block text-sm font-medium text-gray-700">
                                Preu en €
                            </label>
                            <input v-model="form.price" id="price" type="number" class="mt-1 block w-full" required
                                autofocus autocomplete="price" />

                            <label for="unity" class="block text-sm font-medium text-gray-700">
                                Unitats
                            </label>
                            <input v-model="form.unity" id="unity" type="number" class="mt-1 block w-full" required
                                autofocus autocomplete="unity" />
                        </div>

                        <div class="mt-6">
                            <button class="btn" type="submit">
                                Guardar
                            </button>
                        </div>
                    </form>

                </div>
                <div v-if="showExistent" class="existent overflow-y-auto h-[300px]">
                    <div v-for="concept in concepts" :key="concept.id" class="p-2 mb-2 hover:bg-gray-100">
                        <form class="flex justify-between items-center" @submit.prevent="submitExistentConcept(concept, form.unity)">
                            <p class="w-36">
                                {{ concept.nombreConceptoCorto }}</p>
                            <p class="w-36">
                                {{ concept.tipo_concepto.nombreTipo }}
                            </p>
                            <p class="w-24">{{ concept.precio }}€</p>

                            <div class="tooltip  tooltip-left" data-tip="Afegir unitats">
                            <input type="number" class="w-16 rounded-md border border-gray-300" placeholder="0" :id="concept.id" />
                            </div>
                            <button class="btn" type="submit">
                                Add
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>
