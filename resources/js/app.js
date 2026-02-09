import './bootstrap';
import { createApp } from 'vue';
import App from './app.vue';
import router from './router'; // Tu archivo de rutas

const app = createApp(App);
app.use(router); // Activamos el router para el punto 3.1
app.mount('#app');