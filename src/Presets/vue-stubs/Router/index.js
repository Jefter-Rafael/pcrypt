import { createRouter, createWebHistory } from 'vue-router';
// import HomeView from '../views/HomeView.vue'
import loginView from '../Views/auth/login.vue'
const routes = [
    {
        path: '/',
        name: 'home',
        // component: HomeView
    },
    {
        path: '/login',
        name: 'login',
        component: loginView
    }
]
const router = createRouter({
    mode: "history",
    history: createWebHistory(),
    routes
})
export default router