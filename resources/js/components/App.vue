<script setup lang="ts">
import Navbar from "./Navbar.vue";
</script>

<template>
    <header>
        <div class="w-full container mx-auto">
            <div class="w-full flex items-center justify-between">
                <a
                    class="flex items-center text-indigo no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
                    href="/"
                >
                    Invoice<span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-indigo via-ash-gray to-ash-gray"
                        >Generator</span
                    >
                </a>
                <Navbar />
            </div>
        </div>
    </header>
    <main class="h-full">
        <router-view />
    </main>
    <footer class="top-0 w-full px-6 py-0 text-indigo">
        <div class="pt-16 pb-6 text-sm text-center md:text-left fade-in">
            <a
                class="text-gray-500 no-underline hover:no-underline"
                href="#"
            ></a>
        </div>
    </footer>
</template>
