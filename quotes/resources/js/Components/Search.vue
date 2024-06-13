<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
    modelValue: String
});

const emits = defineEmits(['update:modelValue', 'input']);

const inputValue = ref(props.modelValue);

const onInput = (event) => {
    inputValue.value = event.target.value;
    emits('update:modelValue', inputValue.value);
    emits('input', inputValue.value);
};
</script>

<template>
    <div class="InputContainer">
        <input type="text" name="text" class="input" id="input" placeholder="Buscar per paraules clau..."
            v-model="inputValue" @input="onInput">

        <label for="input" class="labelforsearch">
            <svg viewBox="0 0 512 512" class="searchIcon">
                <path
                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                </path>
            </svg>
        </label>
    </div>
</template>

<style scoped>
.InputContainer {
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgb(255, 255, 255);
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.075);
    width: 100%;
}

.input {
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    font-size: 0.9em;
    caret-color: rgb(255, 81, 0);
}

.labelforsearch {
    cursor: text;
    padding: 0px 12px;
}

.searchIcon {
    width: 13px;
}


.searchIcon path {
    fill: rgb(114, 114, 114);
}
</style>
