import { createRouter, createWebHistory } from 'vue-router';

import home from '../components/HomePage.vue';
import admin from '../components/Admin/AdminPanel.vue'
import kasir from '../components/Kasir/KasirPanel.vue'
import kasirTes from '../components/Kasir/KasirTes.vue'
import kasirHistory from '../components/Kasir/kasirHistory.vue'
import kasirTambah from '../components/Kasir/kasirTambah.vue'
import manajer from '../components/Manajer/ManajerPanel.vue'
import about from '../components/AboutPage.vue';
import notFound from '../components/NotFoundPage.vue';
import login from '../components/LoginPage.vue';
import register from '../components/RegisterPage.vue';


const routes = [

    // {
    //     path: '/',
    //     name: 'home', 
    //     component: home
    // },

    {
        path: '/admin',
        name: 'admin', 
        component: admin,
        meta : { requiresRole: 'ADMIN' }
    },

    {
        path: '/manajer',
        name: 'manajer', 
        component: manajer,
        meta: { requiresRole: 'MANAJER' }
    },

    {
        path: '/kasir',
        name: 'kasir', 
        component: kasir,
        meta: { requiresRole: 'KASIR' }
    },

    {
        path: '/kasirTes',
        name: 'kasirTes', 
        component: kasirTes,
        meta: { requiresRole: 'KASIR' }
    },

    {
        path: '/kasir/kasirHistory',
        name: 'kasirHistory', 
        component: kasirHistory,
        meta: { requiresRole: 'KASIR' }
    },

    {
        path: '/kasir/kasirTambah',
        name: 'kasirTambah', 
        component: kasirTambah,
        meta: { requiresRole: 'KASIR' }
    },

    {
        path: '/about',
        name: 'about', 
        component: about
    },

    {
        path: '/',
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
        name: 'notFound',
        component: notFound
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;

router.beforeEach((to, from, next) => {
    const role = localStorage.getItem('role');
    const isLoggedIn = !!role; // Check if the user is logged in

    if (to.matched.some(record => record.meta.requiresRole)) {
        const requiredRole = to.meta.requiresRole;
        if (isLoggedIn) {
            if (role === requiredRole) {
                next();
            } else {
                next({ name: 'notFound' }); // Redirect to not authorized page if the user does not have the required role
            }
        } else {
            next({ name: 'login' }); // Redirect to login if the user is not logged in
        }
    } else {
        next(); // Always call next() to ensure the navigation proceeds
    }
});