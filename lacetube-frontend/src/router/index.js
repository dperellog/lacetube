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
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/FO/LoginView.vue')
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
