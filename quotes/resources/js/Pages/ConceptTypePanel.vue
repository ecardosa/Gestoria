<script setup>
import Header from '@/Components/Header.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Button from '@/Components/Button.vue';

const conceptTypes = ref([]);

onMounted(() => {
  axios.get('/concept-type-panel/get-concept-types')
    .then(response => {
      conceptTypes.value = response.data;
      console.log(response.data);
    });
});

</script>

<template>
<div class="bg-gray-100">
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
          <th></th>
        </tr>
      </thead>
      <tbody>

        <tr v-for="conceptType in conceptTypes" :key="conceptType.id">
          <th>{{ conceptType.id }}</th>
          <td>{{ conceptType.nombreTipo }}</td>
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