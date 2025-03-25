<script setup>
import PostItem from './PostItem.vue';

const post1 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/women/75.jpg',
        name: 'Curalesvic'
    },
    group: null,
    attachments: [
        {
            id: 1,
            name: 'test.png',
            url: 'https://picsum.photos/1000',
            mime: 'image/png'
        },
        {
            id: 2,
            name: 'test2.png',
            url: 'https://picsum.photos/1000',
            mime: 'image/png'
        },
        {
            id: 3,
            name: 'MyDocument.docx',
            url: '#',
            mime: 'application/msword'
        }
    ],
    body:`
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    `,
    create_at: '2025-01-01 15:00'
}

const post2 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/55.jpg',
        name: 'Ballo'
    },
    group: {
        id: 1,
        name: 'Laravel Developers'
    },
    body:`
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    <p>Lorem Ipsum Lorem Ipsum</p>
    `,
    create_at: '2025-01-01 15:00'
}

</script>

<template>
    <div class="flex-1 overflow-auto">
        <PostItem :post="post1" />
        <PostItem :post="post2" />
    </div>
</template>

<style scoped>

</style>