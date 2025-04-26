// src/main.js
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

console.log("✅ Router setup success"); // <--- tambah line ni

createApp(App).use(router).mount('#app')
