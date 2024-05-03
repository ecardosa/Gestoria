<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Header from '@/Components/Header.vue';

// get the concepts
const concepts = ref([]);

onMounted(() => {
    axios.get('/concept-panel/get-concepts')
        .then(response => {
            concepts.value = response.data;
            console.log(response.data);
        });
});


</script>

<template>
    <div class="">
        <Header />
        <button class="btn add-company" @click="showModal">+ Afegir Tipus concepte</button>
  <dialog id="my_modal_1" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg">Afegir Tipus concepte</h3>
    

    </div>
  </dialog>

  <div class="overflow-x-auto mt-16 bg-white">
    <table class="table ">
      <thead>
        <tr>
          <th></th>
          <th>Nom</th>
          <th>Descripció</th>
          <th>Preu</th>
          <th>Tipus</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        <tr v-for="concept in concepts" :key="concept.id">
          <th>{{ concept.id }}</th>
          <td>{{ concept.nombreConceptoCorto }}</td>
          <td>{{ concept.nombreConceptoLargo }}</td>
            <td>{{ concept.precio }}</td>
            <td>{{ concept.tipoId }}</td>
          <td class="flex justify-end space-x-2">
            <Button text="Editar" />
            <Button text="Eliminar" />
          </td>
        </tr>

      </tbody>
    </table>
  </div>
    </div>
</template>

<style scoped></style>