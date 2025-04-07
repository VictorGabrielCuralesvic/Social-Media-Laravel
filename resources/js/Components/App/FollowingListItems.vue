<script setup>
import { ref } from 'vue';
import TextInput from '../TextInput.vue';
import FollowingItem from './FollowingItem.vue';

const searchKeyword = ref('')

</script>

<template>
    <TextInput :model-value="searchKeyword" placeholder="Type to search groups" class="w-full"/>
        <div class="mt-3 h-full overflow-auto">
            <div v-if="false" class="text-gray-400 flex text-center">
                You dont have friends yet.
            </div>
            <div v-else>
                <FollowingItem image="https://picsum.photos/200" title="John Doe" description="Lorem Ipsum"/>
                <FollowingItem image="https://picsum.photos/200" title="John Green" description="Lorem Ipsum"/>
            </div>
        </div>
</template>

<style scoped>

</style>