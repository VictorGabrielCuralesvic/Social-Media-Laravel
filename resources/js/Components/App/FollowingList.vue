<script setup>
import FollowingListItems from './FollowingListItems.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
</script>

<template>
    <div class="px-3 bg-white rounded border py-3 lg:h-full overflow-hidden lg:flex flex-col">
        <!-- Mobile Version -->
        <div class="flex-1 block lg:hidden">
            <Disclosure v-slot="{ open }">
                <DisclosureButton class="w-full text-left">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold">My Followings</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-all" :class="open ? 'rotate-90 transform' : ''">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </DisclosureButton>
                <DisclosurePanel class="mt-2"> <!-- Adicionado espaço para não ficar colado -->
                    <FollowingListItems />
                </DisclosurePanel>
            </Disclosure>
        </div>

        <!-- Desktop Version -->
        <div class="hidden lg:flex lg:flex-col lg:h-full">
            <h2 class="text-2xl font-bold mb-4">My Followings</h2>
            <FollowingListItems />
        </div>
    </div>
</template>
