<script setup>
import { computed, ref, reactive } from 'vue'
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TabItem from './Partials/TabItem.vue';
import Edit from './Edit.vue';
import { usePage, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const coverImageSrc = ref('');
const avatarImageSrc = ref('');
const authUser = usePage().props.auth.user;

const isMyProfile = computed(() => authUser && authUser.id === props.user.id)

const imagesForm = useForm({
    avatar: null,
    cover: null,
})

const props = defineProps({
    errors: Object, 
    
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
      type: Object
    }
});

function onCoverChange(event) {
    imagesForm.cover = event.target.files[0]
    if (imagesForm.cover) {
        const reader = new FileReader()
        reader.onload = () => {
            coverImageSrc.value = reader.result;
        }
        reader.readAsDataURL(imagesForm.cover)
    }
}

function onAvatarChange(event) {
    imagesForm.avatar = event.target.files[0]
    if (imagesForm.avatar) {
        const reader = new FileReader()
        reader.onload = () => {
            avatarImageSrc.value = reader.result;
        }
        reader.readAsDataURL(imagesForm.avatar)
    }
}

function cancelCoverImage() {
    imagesForm.cover = null;
    coverImageSrc.value = null;
}

function cancelAvatarImage() {
    imagesForm.avatar = null;
    avatarImageSrc.value = null;
}

function submitCoverImage() {
    console.log(imagesForm.cover)
    imagesForm.post(route('profile.updateImages'), {
        onSuccess: (user) => {
            console.log(user)
            cancelCoverImage()
        }
    })
}

function submitAvatarImage() {
    console.log(imagesForm.avatar)
    imagesForm.post(route('profile.updateImages'), {
        onSuccess: (user) => {
            console.log(user)
            cancelAvatarImage()
        }
    })
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="w-[800px] mx-auto max-w-[1200px] h-full overflow-auto">
        <!-- Cover And Avatar -->

        <!-- Cover -->
        <div class="group relative bg-white">
            <img :src="coverImageSrc ||     user.cover_url || '/img/default_cover.jpg'" class="w-full h-[200px] object-cover">
            <!-- Edit Cover -->
            <div class="absolute top-2 right-2">

                <!-- Edit Cover Button -->
                <button v-if="!coverImageSrc" class=" bg-gray-50 hover:bg-gray-100 text-gray-800 py-2 px-3 text-sx flex items-center opacity-0 group-hover:opacity-100">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>

                Update Cover Image
                <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0"
                            @change="onCoverChange">
                </button>
                <!-- Edit Cover Button -->
                
                <div v-else class="flex gap-2 bg-white p-2 opacity-0 group-hover:opacity-100">
                    <!-- Cancel Edit Cover Button -->
                    <button @click="cancelCoverImage" class=" bg-gray-50 hover:bg-gray-100 text-gray-800 py-2 px-3 text-sx flex items-center opacity-0 group-hover:opacity-100">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>


                    Cancel
                    </button>
                    <!-- Cancel Edit Cover Button -->
                     
                    <!-- Submit Cover Button -->
                    <button @click="submitCoverImage" class=" bg-gray-800 hover:bg-gray-500 text-gray-50 py-2 px-3 text-sx flex items-center opacity-0 group-hover:opacity-100">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>


                    Submit
                    </button>
                    <!-- Submit Cover Button -->

                </div>
            </div>
            <!-- Cover -->

            <!-- Avatar -->
            <div class="flex">
              <div class="flex items-center justify-center relative group/avatar -mt-[64px] ml-[48px] w-[128px] h-[128px]">

                <img :src="avatarImageSrc || user.avatar_url || '/img/default_avatar.webp'" class="w-full h-full object-cover rounded-full">

                <!-- Edit Avatar Button -->
                <button v-if="!avatarImageSrc" class=" absolute left-0 top-0 right-0 bottom-0 text-gray-800 flex items-center justify-center opacity-0 group-hover/avatar:opacity-100">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>

                <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0"
                            @change="onAvatarChange">
                </button>
                <!-- Edit Avatar Button -->

                    <div v-else class="absolute top-1 right-0 flex flex-col gap-2">
                        <!-- Cancel Edit Avatar Button -->
                        <button @click="cancelAvatarImage" class="w-5 h-5 flex items-center justify-center bg-red-600 text-white rounded-full">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                        </button>
                        <!-- Cancel Edit Avatar Button -->
                        
                        <!-- Submit Avatar Button -->
                        <button @click="submitAvatarImage" class="w-5 h-5 flex items-center justify-center bg-emerald-600 text-white rounded-full">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>

                        </button>
                        <!-- Submit Avatar Button -->

                    </div>
              </div>
              <div class="flex justify-between items-center flex-1 p-4">
                <h2 class="font-bold text-lg">{{ user.username }}</h2>
                <!-- Edit profile button -->
                <SecondaryButton v-if="isMyProfile">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>
                  Edit Profile
                </SecondaryButton>
              </div>
            </div>
        </div>

        <div class="border-t-2">
        <TabGroup>
            <TabList class="flex bg-white p-0.5">
            <!-- Tab About  -->
            <Tab v-if="isMyProfile" as="template" v-slot="{ selected }">
                <TabItem text="About" :selected="selected" />
            </Tab>

            <!-- Tab Posts  -->
            <Tab as="template" v-slot="{ selected }">
                <TabItem text="Posts" :selected="selected" />
            </Tab>

            <!-- Tab Followers -->
            <Tab as="template" v-slot="{ selected }">
                <TabItem text="Followers" :selected="selected" />
            </Tab>

            <!-- Tab Followings -->
            <Tab as="template" v-slot="{ selected }">
                <TabItem text="Followings" :selected="selected" />
            </Tab>

            <!-- Tab Photos -->
            <Tab as="template" v-slot="{ selected }">
                <TabItem text="Photos" :selected="selected" />
            </Tab>
            </TabList>
    
            <!-- About Content -->
            <TabPanels class="mt-2">
              <TabPanel v-if="isMyProfile" key="about" class="bg-white p-3 shadow">
                  <Edit :must-verify-email="mustVerifyEmail" :status="status" />
              </TabPanel>

              <!-- Posts Content -->
              <TabPanel key="posts" class="bg-white p-3 shadow">
                  Posts
              </TabPanel>

              <!-- Followers Content -->
              <TabPanel key="followers" class="bg-white p-3 shadow">
                  Followers
              </TabPanel>

              <!-- Following Content -->
              <TabPanel key="followings" class="bg-white p-3 shadow">
                  Following
              </TabPanel>

              <!-- Photos Content -->
              <TabPanel key="photos" class="bg-white p-3 shadow">
                  Photos
              </TabPanel>
            </TabPanels>
        </TabGroup>
        </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>