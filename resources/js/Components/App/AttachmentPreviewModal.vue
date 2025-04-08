<script setup>

import { PaperClipIcon, XMarkIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid'
import { computed, ref, watch } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import { isImage } from '@/helpers'

const emit = defineEmits(['update:modelValue', 'update:index'])

const props = defineProps({
    attachments: {
        type: Array,
        required: true
    },
    index: Number,
    modelValue: Boolean
})

const currentIndex = ref(props.index)

watch(() => props.index, (newIndex) => {
  currentIndex.value = newIndex
})

watch(currentIndex, (newIndex) => {
  emit('update:index', newIndex)
})

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const attachment = computed(() => {
    return props.attachments[currentIndex.value]
})

function closeModal() {
    show.value = false
}

function prev() {
    if (currentIndex.value > 0) {
        currentIndex.value--;
    }
}

function next() {
    if (currentIndex.value < props.attachments.length - 1) {
        currentIndex.value++;
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
                    class="h-screen w-screen"
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
                        class="flex flex-col w-full transform overflow-hidden rounded bg-white text-left align-middle shadow-xl transition-all"
                    >

                        <button @click="show = false" class="absolute right-3 top-3 w-10 h-10 rounded-full hover:bg-black/10 transition flex items-center justify-center text-gray-100 z-40">
                            <XMarkIcon class="w-4 h-4 font-bold" />
                        </button>

                        <div class="relative group h-full bg-slate-800">
                            <!-- Prev -->
                            <div @click="prev" class="absolute opacity-0 group-hover:opacity-100 w-16 flex items-center h-full left-0 bg-black/20 text-white cursor-pointer">
                                <ChevronLeftIcon class="w-16" />
                            </div>
                            <!-- Prev -->

                            <!-- Next -->
                            <div @click="next" class="absolute opacity-0 group-hover:opacity-100 w-16 flex items-center h-full right-0 bg-black/20 text-white cursor-pointer">
                                <ChevronRightIcon class="w-16"/>
                            </div>
                            <!-- Next -->

                            <div class="flex items-center justify-center w-full h-full p-3">
                                <img v-if="isImage(attachment)" :src="attachment.url" class="w-[700px] h-[700px] object-contain" />
                            <div v-else class="p-32 flex flex-col justify-center items-center">
                                <PaperClipIcon class="w-10 h-10 mb-3" />

                                <small>{{ attachment.name }}</small>
                            </div>
                            </div>
                        </div>

                    </DialogPanel>
                    </TransitionChild>
                </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>

  