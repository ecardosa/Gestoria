<script setup>
import Header from '@/Components/Header.vue';
import EditCompanyModal from '@/Components/Company/EditCompanyModal.vue';
import AddConceptModal from '@/Components/Company/AddConceptModal.vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';
import { computed, ref, defineProps } from 'vue';
import axios from 'axios';

const { props } = usePage();
const companies = ref(props.companies);
const company = ref(props.company);
const companyId = ref(props.company.id);
const loader = ref(false);

const previousCompany = computed(() => {
    const index = companies.value.findIndex(company => company.id === companyId.value);
    if (index === 0) {
        return null;
    }
    return companies.value[index - 1];
});

const nextCompany = computed(() => {
    const index = companies.value.findIndex(company => company.id === companyId.value);
    if (index === companies.value.length - 1) {
        return null;
    }
    return companies.value[index + 1];
});

defineProps({
    company: {
        type: Object,
        required: true,
    },
});

const IdCompany = useForm({
    id: company.value.id,
});

// delete company with confirmation
const deleteCompany = (company) => {
    if (confirm('Estàs segur/a de voler eliminar aquesta empresa? Recorda que també s\'eliminaran tots els conceptes i la quota associada (però es mantindrà l\'historic!!!)')) {
        IdCompany.delete(route('companies.destroy', company.id))
    }
};

const IdRegister = useForm({
    id: '',
});

// delete concept register with confirmation
const deleteConcept = (concept) => {
    IdRegister.id = concept.id;
    if (confirm('Estàs segur/a de voler eliminar aquest concepte?')) {
        IdRegister.delete(route('concepts-registers.destroy', concept.id))
    }
};

// handle comment change
const handleCommentChange = (event) => {
    form.comentarios = event.target.value;
    console.log(company.value.quota.comentarios);
    updateQuota();

};

// handle data change
const handleDataChange = (event) => {
    form.importePropuesta = event.target.value;
    console.log(company.value.quota.importePropuesta);
    updateQuota();

};

// handle checkbox change
const handleCheckboxChange = (event) => {
    form.aceptada = event.target.checked;
    console.log(company.value.quota.aceptada);
    updateQuota();

};  

// handle date acceptation change
const handleDateAcceptationChange = (event) => {
    form.fechaAceptacion = event.target.value;
    console.log(company.value.quota.fechaAceptacion);
    updateQuota();

};

// handle date proposal change
const handleDateProposalChange = (event) => {
    form.fechaPropuesta = event.target.value;
    console.log(company.value.quota.fechaPropuesta);
    updateQuota();
};

const form = useForm({
    importePropuesta: company.value.quota.importePropuesta,
    fechaPropuesta: company.value.quota.fechaPropuesta,
    aceptada: company.value.quota.aceptada,
    fechaAceptacion: company.value.quota.fechaAceptacion,
    comentarios: company.value.quota.comentarios,
});

const updateQuota = () => {
    loader.value = true;
    console.log(form);
    form.patch(route('quotas.update', company.value.quota.id), {
        preserveScroll: true,
        onSuccess: () => {
            loader.value = false;
            console.log(form);
        },
    });
};

const Idform = useForm({
    id: company.value.quota.id,
});

// destroy quota
const destroyQuota = () => {
    if (confirm('Estàs segur/a de voler eliminar aquesta quota?, aquesta acció no es pot desfer')) {
        Idform.delete(route('quotas.destroy', company.value.quota.id))
    }
};

const downloadPdf = () => {
    console.log('download pdf');
    fetch(route('quotas.pdf', company.value.quota.id))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'archivo.pdf');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link); // Limpiar después de la descarga
        })
        .catch(error => {
            console.error('Error al descargar el archivo PDF:', error);
        });
};

</script>

<template>
    <div class="h-screen overflow-hidden">
        <Header />
        <div class="dashboard flex flex-col md:flex-row h-full p-10 space-x-10 overflow-hidden">
            <div class="left w-full md:w-1/2 flex flex-col space-y-6">
                <div class="top flex-none flex flex-col items-left justify-between rounded-lg">
                    <div class="info flex flex-col space-y-2 p-4 rounded-xl bg-gray-50">
                        <div class="flex items-center space-x-2 justify-between">
                            <div class="flex items-center space-x-2">
                                <Link
                                    :class="['hover:bg-gray-400 rounded-full p-1', !previousCompany && 'cursor-not-allowed opacity-50']"
                                    :href="previousCompany ? route('companies.show', previousCompany.id) : null">
                                <img src="/assets/img/angulo-izquierdo.svg" alt="" class="w-3 h-3">
                                </Link>
                                <h1 class="text-md font-bold">
                                    {{ $page.props.company.nomEmpresa }}
                                </h1>
                                <Link
                                    :class="['hover:bg-gray-400 rounded-full p-1', !nextCompany && 'cursor-not-allowed opacity-50']"
                                    :href="nextCompany ? route('companies.show', nextCompany.id) : null">
                                <img src="/assets/img/angulo-derecho.svg" alt="" class="w-3 h-3">
                                </Link>
                            </div>
                            <div class="flex items-center flex-row space-x-2">
                                <div style="padding-top: 0.2em; padding-bottom: 0.2rem"
                                    class="flex items-center space-x-1 text-sm px-2 bg-gray-200 text-gray-800 rounded-full w-min">
                                    <div style="width: 0.4rem; height: 0.4rem" class="bg-gray-500 rounded-full"></div>
                                    <div>
                                        <p class="p-1"> {{ $page.props.company.idperfil ?
                                            $page.props.company.perfil.nomPerfil :
                                            'Senseperfil' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="actions flex items-center space-x-1 bg-gray-200 px-2 py-1 rounded-full">
                                    <EditCompanyModal :company="$page.props.company" />
                                    <button class="hover:bg-gray-400 rounded-full p-1"
                                        @click="deleteCompany($page.props.company)">
                                        <img src="/assets/img/basura.svg" alt="Delete" class="w-4 h-4">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom flex-auto overflow-auto relative"
                    v-if="$page.props.company.registro_concepto.length > 0">
                    <div class="conceptos flex flex-col space-y-4 border-b-2 border-gray-200 sticky top-0  z-10 bg-white">
                        <div class="concepto  p-4 rounded-lg">
                            <div class="flex justify-between">
                                <h2 class="text-md font-bold w-1/2">Conceptes</h2>
                                <p class="font-bold">Unitats</p>
                                <p class="text-right font-bold mr-4 w-1/4">Preu</p>
                                <AddConceptModal/>
                            </div>
                        </div>
                    </div>

                    <div v-for="concepto in company.registro_concepto" :key="concepto.id"
                        class="concepto  p-4 rounded-lg hover:bg-gray-100">
                        <div class="flex justify-between">
                            <h2 class="text-md w-1/2">
                                {{ concepto.concepto.nombreConceptoCorto }}</h2>
                            <p>{{ concepto.unidades }}</p>
                            <p class="text-right w-1/4">
                                {{ concepto.unidades * concepto.concepto.precio }}€
                            </p>

                            <button @click="deleteConcept(concepto)"
                                class="btn btn-circle btn-outline w-[20px] min-h-[20px] h-[20px] place-self-center pl-1 pr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-[15px] w-[15px] ml-[1px] mb-[1px]"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div v-else class="bottom flex flex-auto overflow-auto relative space-x-4">
                    <h2 class="text-md font-bold">Encara no hi ha conceptes, afegeix-ne un al botó!
                    </h2>
                    <span class="text-blue-800">-</span>

                    <AddConceptModal/>
                </div>
            </div>

            <div class="right w-full md:w-1/2 flex flex-col space-y-10">
                <div class="top flex-2 flex flex-col bg-gray-50 p-4 items-left rounded-xl">
                    <div class="info flex items-center space-x-4">
                        <h1 class="text-md font-bold">Informació de la quota - {{ $page.props.company.quota.id }}</h1>  <div class="loader" :class="{ active: loader }">

                        </div> 
                    </div>
                    <div class="precio mt-2 flex flex-row space-x-4">
                        <div class="total w-full">
                            <label class="form-control w-full w-full">
                                <div class="label">
                                    <span class="label-text">Quota resultant (en €): </span>
                                </div>
                                <input type="number" placeholder="Inserta una cuota aproximada..."
                                    class="input w-full h-8 !text-black !bg-white"
                                    :value="(company.registro_concepto.reduce((acc, concepto) => acc + concepto.unidades * concepto.concepto.precio, 0) / 12).toFixed(2)" disabled />
                                </label>
                        </div>
                        <div class="final w-full">
                            <div class="label">
                                <span class="label-text">Quota final (en €):</span>
                            </div>
                            <input type="number" placeholder="Inserta una quota aproximada..." @change="handleDataChange"
                                class="input w-full h-8" v-model="$page.props.company.quota.importePropuesta"/>
                        </div>
                    </div>
                    <div class="dates">
                        <div class="proposta">
                            <label class="form-control w-full w-full">
                                <div class="label">
                                    <span class="label-text">Data de la proposta: </span>
                                </div>
                                <input type="date" placeholder="Inserta una quota aproximada..."
                                    class="input w-full h-8" v-model="$page.props.company.quota.fechaPropuesta" @change="handleDateProposalChange"/>
                            </label>
                        </div>
                        <div class="acceptaccio flex items-center justify-left flex-col">
                            <div class="label w-full">
                                <span class="label-text w-full">Data de l'acceptació: </span>
                            </div>
                            <div class="flex items-center flex-row justify-between w-full space-x-4">
                                <div class="form-control ">
                                    <label class="label cursor-pointer gap-1">
                                        <input type="checkbox" class="checkbox" :checked="$page.props.company.quota.aceptada"
                                            @change="handleCheckboxChange" />
                                        <span class="label-text">Acceptada</span>
                                    </label>
                                </div>

                                <input type="date" placeholder="Inserta una quota aproximada..."
                                    class="input w-full h-8" v-model="$page.props.company.quota.fechaAceptacion" @change="handleDateAcceptationChange"/>
                            </div>
                        </div>
                    </div>
                    <div class="acciones flex space-x-4 justify-end mt-4">
                        <button @click="downloadPdf"
                            class="hover:bg-gray-400 rounded-xl p-2 flex items-center space-x-2 border border-gray-400">
                            <img src="/assets/img/archivo-pdf.svg" alt="PDF" class="w-5 h-5">
                            <span class="text-sm font-bold">Resum</span>
                        </button>
                        <button @click="destroyQuota"
                            class="hover:bg-gray-400 rounded-xl p-2 flex items-center space-x-2 border border-gray-400">
                            <img src="/assets/img/expediente.svg" alt="PDF" class="w-5 h-5">
                            <span class="text-sm font-bold">Nova quota</span>
                        </button>
                    </div>
                </div>
                <div class="bottom flex-1 flex flex-col bg-gray-50 p-6 items-left rounded-lg space-y-4">
                    <h2 class="text-md font-bold">Comentari</h2>
                    <div class="flex w-full h-full">
                        <textarea placeholder="Fes un comentari..." @change="handleCommentChange"
                            class="textarea textarea-bordered textarea-lg w-full" v-model="$page.props.company.quota.comentarios"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.dashboard {
    height: calc(100% - 80px);
}

.left .bottom {
    overflow-y: auto;
}

.conceptos {
    position: sticky;
    top: 0;
    z-index: 10;
}

.cursor-not-allowed {
    cursor: not-allowed;
    pointer-events: none;
}

.opacity-50 {
    opacity: 0.5;
}

.loader {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      position: relative;
      display: none;
      animation: rotate 1s linear infinite
    }
    .loader::before {
      content: "";
      box-sizing: border-box;
      position: absolute;
      inset: 0px;
      border-radius: 50%;
      border: 1px solid #000000;
      animation: prixClipFix 2s linear infinite ;
    }

    @keyframes rotate {
      100%   {transform: rotate(360deg)}
    }

    @keyframes prixClipFix {
        0%   {clip-path:polygon(50% 50%,0 0,0 0,0 0,0 0,0 0)}
        25%  {clip-path:polygon(50% 50%,0 0,100% 0,100% 0,100% 0,100% 0)}
        50%  {clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,100% 100%,100% 100%)}
        75%  {clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 100%)}
        100% {clip-path:polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 0)}
    }

    .loader.active {
      display: block;
    }
</style>
