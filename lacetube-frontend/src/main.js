import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

//Importar CSS Bootswatch+Bootstrap:
import '@/assets/styles/bootstrap-vanilla.min.css';
import '@/assets/styles/bootstrap.min.css';
import '@/assets/styles/custom.css';
import '@/assets/js/bootstrap.min.js';
import moment from 'moment';
import 'moment/dist/locale/ca';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


moment.locale('ca');


const app = createApp(App)


app.use(createPinia())
app.use(router)

app.component('VueDatePicker', VueDatePicker);

app.mount('#app')
