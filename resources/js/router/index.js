import { createRouter, createWebHistory } from 'vue-router';

import home from '../components/HomePage.vue';
import about from '../components/AboutPage.vue';
import notFound from '../components/NotFoundPage.vue';
import login from '../components/LoginPage.vue';
import register from '../components/RegisterPage.vue';


const routes = [

    {
        path: '/',
        name: 'home', 
        component: home
    },

    {
        path: '/about',
        name: 'about', 
        component: about
    },

    {
        path: '/login',
        name: 'login', 
        component: login
    },
    
    {
        path: '/register',
        name: 'register', 
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