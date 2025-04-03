<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: false,
});

const props = defineProps({
    placeholder: {
        type: String,
        default: 'Digite algo...'
    },
    autoResize: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

function onInputChange($event) {
    emit('update:modelValue', $event.target.value)
    adjustHeight()
    
}

function adjustHeight() {
    if (props.autoResize) {
        input.value.style.height = 'auto';
        input.value.style.height = input.value.scrollHeight + 'px';
    }
}

onMounted(() => {
    adjustHeight()
})

</script>

<template>
    <textarea class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" 
    v-model="model"
    @input="onInputChange"
    ref="input"
    :placeholder="placeholder"></textarea>
</template>
