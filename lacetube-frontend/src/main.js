import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

//Importar CSS Bootswatch+Bootstrap:
import '@/assets/styles/bootstrap-vanilla.min.css';
import '@/assets/styles/bootstrap.min.css';
import '@/assets/styles/custom.css';
import '@/assets/js/bootstrap.min.js';

//Import Fontawesome:
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faUserSecret);


const app = createApp(App)

app.component('font-awesome-icon', FontAwesomeIcon);

app.use(createPinia())
app.use(router)

app.mount('#app')
