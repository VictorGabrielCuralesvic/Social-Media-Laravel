<script setup>
import PostItem from './PostItem.vue';

defineProps({
    posts: Array
})
</script>

<template>
    <div class="flex-1 overflow-auto">
        <PostItem v-for="post of posts" :key="post.id" :post="post" />
    </div>
</template>

<style scoped>

</style>