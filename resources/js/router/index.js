import { createRouter, createWebHistory } from 'vue-router';
import Login from '../Pages/Auth/Login.vue';
import Register from '../Pages/Auth/Register.vue';

const routes = [
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  // other routes
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
