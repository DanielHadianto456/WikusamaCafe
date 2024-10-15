import { createRouter, createWebHistory } from 'vue-router';

import home from '../components/HomePage.vue';
import admin from '../components/Admin/AdminPanel.vue'
import listMenu from '../components/Admin/ListMenu.vue'
import addMenu from '../components/Admin/AddMenu.vue'
import editMenu from '../components/Admin/EditMenu.vue'
import listMeja from '../components/Admin/ListMeja.vue'
import editUser from '../components/Admin/EditUser.vue'
import listUser from '../components/Admin/ListUser.vue'
import addMeja from '../components/Admin/AddMeja.vue'
import editMeja from '../components/Admin/EditMeja.vue'
import kasir from '../components/Kasir/KasirPanel.vue'
import kasirTes from '../components/Kasir/KasirTes.vue'
import kasirHistory from '../components/Kasir/kasirHistory.vue'
import kasirTambah from '../components/Kasir/kasirTambah.vue'
import kasirDetail from '../components/Kasir/kasirDetail.vue'
import kasirTambahDetail from '../components/Kasir/KasirTambahDetail.vue'
import manajer from '../components/Manajer/ManajerPanel.vue'
import manajerHistory from '../components/Manajer/ManajerHistory.vue'
import manajerDetail from '../components/Manajer/ManajerDetail.vue'
import about from '../components/AboutPage.vue';
import notFound from '../components/NotFoundPage.vue';
import login from '../components/LoginPage.vue';
import addUser from '../components/RegisterPage.vue';


const routes = [
    {
        path: '/',
        name: 'home', 
        component: home,
        meta: { requiresRole: ['KASIR', 'ADMIN', 'MANAJER'] }
    },
    {
        path: '/admin',
        name: 'admin', 
        component: admin,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/menu',
        name: 'menu', 
        component: listMenu,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/menu/add',
        name: 'addMenu', 
        component: addMenu,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/menu/edit/:id',
        name: 'editMenu', 
        component: editMenu,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/meja',
        name: 'listMeja', 
        component: listMeja,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/meja/add',
        name: 'addMeja', 
        component: addMeja,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/meja/edit/:id',
        name: 'editMeja', 
        component: editMeja,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/user',
        name: 'listUser', 
        component: listUser,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/user/edit/:id',
        name: 'editUser', 
        component: editUser,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/admin/user/add',
        name: 'addUser', 
        component: addUser,
        meta: { requiresRole: ['ADMIN'] }
    },
    {
        path: '/manajer',
        name: 'manajer', 
        component: manajer,
        meta: { requiresRole: ['MANAJER'] }
    },
    {
        path: '/manajer/manajerHistory',
        name: 'manajerHistory', 
        component: manajerHistory,
        meta: { requiresRole: ['MANAJER'] }
    },
    {
        path: '/manajer/manajerDetail/:id',
        name: 'manajerDetail', 
        component: manajerDetail,
        meta: { requiresRole: ['MANAJER'] }
    },
    {
        path: '/kasir',
        name: 'kasir', 
        component: kasir,
        meta: { requiresRole: ['KASIR'] }
    },
    {
        path: '/kasirTes',
        name: 'kasirTes', 
        component: kasirTes,
        meta: { requiresRole: ['KASIR'] }
    },
    {
        path: '/kasir/kasirHistory',
        name: 'kasirHistory', 
        component: kasirHistory,
        meta: { requiresRole: ['KASIR'] }
    },
    {
        path: '/kasir/kasirTambah',
        name: 'kasirTambah', 
        component: kasirTambah,
        meta: { requiresRole: ['KASIR'] }
    },
    {
        path: '/kasir/kasirTambahDetail/:id',
        name: 'kasirTambahDetail', 
        component: kasirTambahDetail,
        meta: { requiresRole: ['KASIR'] }
    },
    {
        path: '/kasir/kasirDetail/:id',
        name: 'kasirDetail', 
        component: kasirDetail,
        meta: { requiresRole: ['KASIR'] }
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
        path: '/:pathMatch(.*)*',
        name: 'notFound',
        component: notFound
    },
];

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
            if (requiredRole.includes(role)) {
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