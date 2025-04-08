<script setup>

import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { PencilIcon, TrashIcon, EllipsisVerticalIcon, HandThumbUpIcon, ChatBubbleLeftRightIcon, ArrowDownTrayIcon } from '@heroicons/vue/20/solid'
import {router} from '@inertiajs/vue3'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import PostModal from './PostModal.vue'
import { ref } from 'vue'
import PostUserHeader from './PostUserHeader.vue'
import { isImage } from '@/helpers'
import { PaperClipIcon } from '@heroicons/vue/24/solid'

const showEditModal = ref(false)

const emit = defineEmits(['attachmentClick'])

const props = defineProps({
       
    post: Object
    
})

const handlePostUpdated = (updatedBody) => {
    Object.assign(props.post, updatedPost)
}

function deletePost() {
    if (window.confirm('Are you sure you want to delete this post?')) {
        router.delete(route('post.destroy', props.post), {
            preserveScroll: true
        })
    }
}

function openAttachment(attachment, ind) {
    console.log(attachment)
    emit('attachmentClick', props.post, ind)
}

</script>

<template>
    <div class="bg-white border rounded p-4 mb-3">
        <div class="flex items-center justify-between gap-2 mb-3">
            <PostUserHeader :post="post" :show-time="true" />
            <div>
                <!-- 3 dots -->
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton
                            class="w-8 h-8 rounded-full hover:bg-black/20 transition flex items-center justify-center"
                            >
                            <EllipsisVerticalIcon

                                class="w-5 h-5"
                                aria-hidden="true"
                            />
                            </MenuButton>
                        </div>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                            class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none z-50"
                            >
                            <div class="px-1 py-1">
                                <MenuItem v-slot="{ active }">
                                <button
                                    @click="showEditModal = true"
                                    :class="[
                                    active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                                >
                                    <PencilIcon
                                    class="mr-2 h-5 w-5"
                                    aria-hidden="true"
                                    />
                                    Edit
                                </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <button
                                    @click="deletePost"
                                    :class="[
                                    active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                                >
                                    <TrashIcon
                                    class="mr-2 h-5 w-5"
                                    aria-hidden="true"
                                    />
                                    Delete
                                </button>
                                </MenuItem>
                            </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                    <!-- 3 dots end -->
            </div>
        </div>
        <div class="mb-3">
        <Disclosure v-slot="{ open }">

            <div class="ck-content" v-if="!open" v-html="post.body.substring(0, 200)"></div>

            <template v-if="post.body.length > 200">
                <DisclosurePanel>
                    <div v-html="post.body"></div>
                </DisclosurePanel>
                <div class="flex justify-end">
                    <DisclosureButton class="text-blue-500 hover:underline">
                    {{ open ? 'Read Less' : 'Read More' }}
                    </DisclosureButton>
                </div>
            </template>

        </Disclosure>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 mb-3"> 

            <template v-for="(attachment, ind) of post.attachments.slice(0, 6)">

                <div @click="openAttachment(attachment, ind)" class="group aspect-asquare bg-blue-100 flex flex-col items-center justify-center text-gray-500 relative cursor-pointer">

                    <div v-if="ind === 5 && post.attachments.length > 6" class="absolute left-0 top-0 right-0 bottom-0 z-10 bg-black/30 text-white flex items-center justify-center">
                        +{{ post.attachments.length - 6 }} more
                    </div>

                    <!-- Download -->
                    <a :href="route('post.download', attachment)" class="opacity-0 group-hover:opacity-100 transition-all w-8 h-8 bg-gray-700 roundedf flex items-center justify-center text-gray-100 absolute right-2 top-2 cursor-pointer hover:bg-gray-800">
                        <ArrowDownTrayIcon class="w-4 h-4" />
                    </a>
                    <!-- Download -->

                    <img v-if="isImage(attachment)" :src="attachment.url" class="object-cover aspect-asquare" />

                    <div v-else class="flex flex-col justify-center items-center">

                        <PaperClipIcon class="w-10 h-10 mb-3" />

                        <small>{{ attachment.name }}</small>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex gap-2">

            <button class="text-gray-800 flex gap-1 items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg py-2 px-4 flex-1">
                <HandThumbUpIcon class="w-5 h-5 mr-2" />
                Like
            </button>

            <button class="text-gray-800 flex gap-1 items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg  py-2 px-4 flex-1">
                <ChatBubbleLeftRightIcon class="w-5 h-5 mr-2" />
                Comments
            </button>
        </div>
    </div>
     <PostModal :post="post" v-model="showEditModal" @updated="handlePostUpdated" />
</template>

<style scoped>

</style>