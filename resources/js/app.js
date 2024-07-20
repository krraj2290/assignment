import { createApp } from 'vue';
import DashboardComponent from './views/Dashboard.vue';


const app = createApp({});
app.component('dashboard-component', DashboardComponent);
app.mount('#app');
