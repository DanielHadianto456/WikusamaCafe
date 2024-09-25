import { createRouter, createWebHistory } from 'vue-router';

import home from '../components/HomePage.vue';
import about from '../components/AboutPage.vue';
import notFound from '../components/NotFoundPage.vue';
import login from '../components/LoginPage.vue';
import register from '../components/RegisterPage.vue';


const routes = [

    {
        path: '/',
        component: home
    },

    {
        path: '/about',
        component: about
    },

    {
        path: '/login',
        component: login
    },
    
    {
        path: '/register',
        component: register
    },

    {
        path: '/:pathMatch(.*)*',
        component: notFound
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;