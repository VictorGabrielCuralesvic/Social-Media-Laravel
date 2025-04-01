<script setup>
import CreatePost from '@/Components/App/CreatePost.vue';
import FollowingList from '@/Components/App/FollowingList.vue';
import GroupItem from '@/Components/App/GroupItem.vue';
import GroupList from '@/Components/App/GroupList.vue';
import PostList from '@/Components/App/PostList.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    posts: Object,
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Social Media WebSite"></Head>

    <AuthenticatedLayout>
        <!-- <pre>{{ posts }}</pre> -->
        <div class="grid lg:grid-cols-12 gap-3 p-4 h-full">
            <div class="lg:col-span-3 lg:order-1 h-full overflow-hidden">
                <GroupList />
            </div>
            <div class="lg:col-span-3 lg:order-3 h-ffull overflow-auto">
                <FollowingList />
            </div>
            <div class="lg:col-span-6 lg:order-2 h-full overflow-hidden flex flex-col">
                <CreatePost />
                <PostList :posts="posts.data" class="flex-1" />
            </div>
        </div>
    </AuthenticatedLayout>  
</template>
