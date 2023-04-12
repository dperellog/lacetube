import { createRouter, createWebHistory } from 'vue-router'
import Index from '../views/FO/Index.vue'
import IndexBO from '@/views/BO/Index.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/gestio',
      component: IndexBO
    },
    {
      path: '/',
      name: 'home',
      component: Index
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/FO/LoginView.vue')
    },
    {
      path: '/tauler',
      name: 'tauler',
      component: () => import('../views/FO/Tauler.vue')
    }
  ]
});

// router.beforeEach((to, from, next) => {
//   const authUser = store.getters["auth/authUser"];
//   const reqAuth = to.matched.some((record) => record.meta.requiresAuth);
//   const loginQuery = { path: "/login", query: { redirect: to.fullPath } };

//   if (reqAuth && !authUser) {
//     store.dispatch("auth/getAuthUser").then(() => {
//       if (!store.getters["auth/authUser"]) next(loginQuery);
//       else next();
//     });
//   } else {
//     next(); // make sure to always call next()!
//   }
// });

export default router
