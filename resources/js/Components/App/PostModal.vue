<script setup>

import { XMarkIcon, PaperClipIcon, PaperAirplaneIcon } from '@heroicons/vue/24/solid'
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
import { isImage } from '@/helpers'

const isOpen = ref(true)

const props = defineProps({
    post: {
        type: Object,
        required: true
    },
    modelValue: Boolean
})

/**
 * {
 *     file: File,
 *     url: '',
 * }
 * @type {Ref<UnwrapRef<*[]>>}
 */
const attachmentFiles =  ref([])

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
    resetModal()
}

function resetModal() {
    form.reset()
    attachmentFiles.value = []
}

const form = useForm({
    id: props.post.id,
    body: props.post.body ,
    attachments: []
})

function submit() {

    
    form.attachments = attachmentFiles.value.map(myFile => myFile.file)
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
                closeModal()
            }
        })
    }
    

}

async function onAttachmentChoose($event) {
    console.log($event.target.files)
    for (const file of $event.target.files) {
        const myFile = {
            file,
            url: await readFile(file)
        }
        attachmentFiles.value.push(myFile)
    }
    $event.target.value =  null;
    console.log(attachmentFiles.value)
}

async function readFile(file) {
    return new Promise((res, rej) => {
        if (isImage(file)) {
        const reader =  new FileReader();
        reader.onload = () => {
            res(reader.result)
        }
        reader.onError = rej

        reader.readAsDataURL(file)
        } else {
            res(null)
        }
    })
}

function removeFile(myFile) {
    attachmentFiles.value = attachmentFiles.value.filter(f => f !== myFile)
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

                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 my-3"> 

                                <template v-for="(myFile, ind) of attachmentFiles">

                                    <div class="group aspect-asquare bg-blue-100 flex flex-col items-center justify-center text-gray-500 relative">

                                        <button 
                                            @click="removeFile(myFile)"
                                            class="absolute z-20 right-1 top-1 w-7 h-7 flex items-center justify-center bg-black/80 text-white rounded-full hover:bg-black/20">
                                            <XMarkIcon class="h-5 w-5" />
                                        </button>

                                        <img v-if="isImage(myFile.file)" :src="myFile.url" class="object-cover aspect-asquare" />

                                        <template v-else>

                                            <PaperClipIcon class="w-10 h-10 mb-3" />

                                            <small class="text-center">{{ myFile.file.name }}</small>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            
                        </div>

                        <!-- Rodape fixo -->
                        <div class="flex gap-2 py-3 px-4">
                            <button
                                type="button"
                                class="flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 w-full relative"
                                @click="submit"
                            >
                                <PaperClipIcon class="w-4 h-4 mr-2" />
                                Attach Files
                                <input @click.stop @change="onAttachmentChoose" type="file" multiple class="absolute left-0 top-0 right-0 bottom-0 opacity-0">
                            </button>
                            <button
                                type="button"
                                class="flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 w-full"
                                @click="submit"
                            >
                                <PaperAirplaneIcon class="w-4 h-4 mr-2" />
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

  