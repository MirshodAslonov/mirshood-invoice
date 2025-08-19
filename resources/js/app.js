import '../css/app.css';
import 'flowbite';
import 'animate.css';

import { createApp } from "vue";
import App from "./App.vue"; // bitta App.vue ochamiz
import router from "./router";

import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
});

createApp(App).use(router).mount("#app");
