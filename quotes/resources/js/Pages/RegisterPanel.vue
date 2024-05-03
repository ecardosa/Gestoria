<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Header from '@/Components/Header.vue';

// toogle by buttons to show the concepts or the entries 
const showConcepts = ref(false);
const showEntries = ref(false);
const toggleConceptes = () => {
    showConcepts.value = !showConcepts.value;
   
};

const toggleEntrades = () => {
    showEntries.value = !showEntries.value;
  
};

</script>

<template>
    <Header/>

    <div class="flex justify-center mt-10 space-x-4">
        <button class="btn add-company" @click="toggleConceptes">Conceptes</button>
        <button class="btn add-company" @click="toggleEntrades">Entrades</button>
    </div>

    <div class="conceptes" v-if="showConcepts">
        Conceptes
    </div>

    <div class="entrades" v-if="showEntries">
        Entrades
    </div>
</template>

<style scoped></style>