<script setup>

import { ref } from 'vue';
import TextInput from '../TextInput.vue';
import GroupItem from './GroupItem.vue';

const searchKeyword = ref('');

</script>

<template>
    <TextInput :model-value="searchKeyword" placeholder="Type to search groups" class="w-full mt-4"/>
        <div class="mt-3 h-full overflow-auto">
            <div v-if="false" class="text-gray-400 flex text-center">
                You are not joined to any groups
            </div>
            <div v-else>
                <GroupItem image="https://picsum.photos/200" title="Laravel Developers" description="Lorem Ipsum" />
                <GroupItem image="https://picsum.photos/200" title="Vue.js Developers" description="Lorem Ipsum"/>
            </div>
        </div>
</template>

<style scoped>

</style>