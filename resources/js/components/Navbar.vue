<script setup>
import useAuth from "../stores/auth.js";
const auth = useAuth();
</script>

<template>
    <div v-show="auth.hasUser" class="flex w-1/2 justify-end content-center">
        <router-link
            class="rounded-b-xl text-ash-gray bg-indigo inline-block no-underline hover:bg-ash-gray hover:text-indigo text-center h-10 p-2 md:h-auto md:p-4 transform duration-300 ease-in-out"
            @click="auth.clear()"
            :to="{ name: 'home' }"
        >
            <svg
                class="md:w-6 md:h-6 w-5 h-5 text-gray-100 dark:text-gray-100"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 16 16"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"
                />
            </svg>
        </router-link>
    </div>
    <div v-show="!auth.hasUser" class="flex w-1/2 justify-end content-center">
        <router-link
            class="inline-block text-indigo no-underline hover:text-ash-gray hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 transform hover:scale-125 duration-300 ease-in-out"
            :to="{ name: 'about' }"
        >
            About
        </router-link>
    </div>
</template>
