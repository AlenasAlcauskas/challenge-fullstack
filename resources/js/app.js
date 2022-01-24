require('./bootstrap');

import {createApp} from 'vue';
import {createStore} from 'vuex';
import createPersistedState from "vuex-persistedstate";
import router from './router'
import App from './App.vue';

const store = createStore({
    state: {
        user: null,
    },
    getters: {
        user(state) {
            return state.user;
        }
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload.user;
        },
        logout(state) {
            state.user = null;
        }
    },
    actions: {
        getUser({commit}) {
            return new Promise(async (resolve, reject) => {
                await axios.get('/sanctum/csrf-cookie');

                axios.get('/auth/me').then(response => {
                    commit('setUser', {user: response.data.data});
                    resolve()
                }).catch(error => reject())
            });

        },
        logout() {
            store.commit('logout')
            axios.post('/auth/logout')
        }
    },
    plugins: [createPersistedState()]
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.auth)) {
        if (store.getters.user) {
            next();
            return;
        }
        if (to.query?.social) {
            store.dispatch('getUser')
                .then(response => {
                    if (store.getters.user) {
                        next()
                    }
                })
                .catch(error => {
                    next('/login')
                })
        } else {
            next('/login')
        }
    } else {
        next();
    }
})

createApp({components: {App}})
    .use(router)
    .use(store)
    .mount('#app')
