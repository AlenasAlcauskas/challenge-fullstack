import { createRouter, createWebHistory } from 'vue-router'

import Login from "../pages/Login";
import Comments from "../pages/Comments";

const routes = [
    {
        path: '/comments/:parent?',
        name: 'comments',
        component: Comments,
        meta: {
            auth: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
