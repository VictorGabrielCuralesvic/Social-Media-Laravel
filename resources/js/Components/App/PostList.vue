<script setup>
import { ref } from 'vue';
import AttachmentPreviewModal from './AttachmentPreviewModal.vue';
import PostItem from './PostItem.vue';

const showAttachmentsModal = ref(false)
const previewAttachmentsPost = ref({})

defineProps({
    posts: Array
})

function openAttachmentPreviewModal(post, index) {
    debugger
    previewAttachmentsPost.value = {
        post,
        index
    }
    showAttachmentsModal.value = true;
}

</script>

<template>
    <div class="flex-1 overflow-auto">

        <PostItem v-for="post of posts" :key="post.id" :post="post" @attachmentClick="openAttachmentPreviewModal" />

        <AttachmentPreviewModal :attachments="previewAttachmentsPost.post?.attachments || []" :index="previewAttachmentsPost.index" v-model="showAttachmentsModal" />
    </div>
</template>

<style scoped>

</style>