import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

//Importar CSS Bootswatch+Bootstrap:
import '@/assets/styles/bootstrap-vanilla.min.css';
import '@/assets/styles/bootstrap.min.css';
import '@/assets/styles/custom.css';
import '@/assets/js/bootstrap.min.js';

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
