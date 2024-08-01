import "./bootstrap";
import { createApp } from "vue";
import App from "./components/App.vue";
import Router from "./router/index.js";
import { createPinia } from "pinia";
import { VueClipboard } from "@soerenmartius/vue3-clipboard";
import VueTheMask from "vue-the-mask";

createApp(App)
    .use(Router)
    .use(createPinia())
    .use(VueClipboard)
    .use(VueTheMask)
    .mount("#app");
