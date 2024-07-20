import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import CampaignForm from '../views/CampaignForm.vue';

const routes = [
  { path: '/', component: Dashboard },
  { path: '/campaigns/create', component: CampaignForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
