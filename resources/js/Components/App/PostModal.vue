<script setup>

import { XMarkIcon } from '@heroicons/vue/24/solid'
import { computed, ref } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import InputTextArea from '../InputTextArea.vue'
import PostUserHeader from './PostUserHeader.vue'
import { useForm } from '@inertiajs/vue3'
import { Ckeditor, useCKEditorCloud } from '@ckeditor/ckeditor5-vue'

const isOpen = ref(true)

const props = defineProps({
    post: {
        type: Object,
        required: true
    },
    modelValue: Boolean
})

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const emit = defineEmits(['update:modelValue'])

const cloud = useCKEditorCloud({
    version: '44.3.0',
})

const editor = computed(() => {
    if (!cloud.data.value) return null
    return cloud.data.value.CKEditor.ClassicEditor
})

const editorConfig = computed(() => {
    if (!cloud.data.value) return null
    
    const { Essentials, Paragraph, Bold, Italic, Heading, List, Link } = cloud.data.value.CKEditor
    
    return {
        licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzUyNjA3OTksImp0aSI6ImQ2M2MwNzUwLTE0OGEtNDAyNi1hMzZlLTRjMTFhYmM4ODk2NCIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjMzMzM4OTY5In0.Ve9pQeQO4HPD4HKKcCBw9z_JIt1BMPg81D6EssuHsgQ0Ygps_OIGGnJRSpnGN-CErPjpJ3727pSPOUOKOSoavw', 
        plugins: [Essentials, Paragraph, Bold, Italic, Heading, List, Link],
        toolbar: [
            'heading', '|',
            'bold', 'italic', '|',
            'numberedList', 'bulletedList', '|',
            'link', '|',
            'undo', 'redo',
        ]
    }
})

function closeModal() {
  show.value = false
}

const form = useForm({
    id: props.post.id,
    body: props.post.body 
})

function submit() {
    if (form.id) {
            form.put(route('post.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
                window.location.reload();
            },
            onError: (errors) => {
                console.error('Update failed:', errors)
            }
        }) 
    }
    else {
        form.post(route('post.create'), {
            preserveScroll: true,
            onSuccess: () => {
                show.value = false;
                form.reset();
            }
        })
    }
    

}

</script>

<template>
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
                >
                <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>
        
                <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                    >
                    <DialogPanel
                        class="w-full max-w-md transform overflow-hidden rounded bg-white text-left align-middle shadow-xl transition-all"
                    >
                    <!-- Cabeçalho fixo  -->
                        <DialogTitle
                        as="h3"
                        class="flex items-center justify-between py-3 px-4 font-medium bg-gray-100 text-gray-900"
                        >
                            {{ form.id ? 'Update Post' : 'Create Post' }}
                            <button @click="show = false" class="w-8 h-8 rounded-ful hover:bg-black/5 transition flex items-center justify-center">
                                <XMarkIcon class="w-4 h-4" />
                            </button>
                        </DialogTitle>
                        <!-- Cabeçalho fixo  -->

                        <div class="p-3 mt-2">
                            <PostUserHeader :post="post" :show-time="false" class="mb-3"/>

                            <ckeditor
                                    :editor="editor"
                                    v-model="form.body"
                                    :config="editorConfig"
                                    class="w-full min-h-[150px] max-h-[60vh] text-base leading-relaxed"
                            />

                            <!-- <InputTextArea v-model="form.body" class="w-full min-h-[150px] max-h-[60vh] text-base leading-relaxed" /> -->
                            
                        </div>

                        <!-- Rodape fixo -->
                        <div class="py-3 px-4">
                            <button
                                type="button"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 w-full"
                                @click="submit"
                            >
                                Submit!
                            </button>
                        </div>
                        <!-- Rodape fixo -->
                    </DialogPanel>
                    </TransitionChild>
                </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>

  