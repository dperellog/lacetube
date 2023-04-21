import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '@/stores/userStore';
import Index from '@/views/FO/Index.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    //Rutes de FRONT OFFICE:
    {
      path: '/',
      name: 'home',
      component: Index
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/FO/LoginView.vue'),
      beforeEnter: (to, from, next) => {
        const userStore = useUserStore()

        if (userStore.isLogged) {
          next({ name: 'home' })
        } else {
          next()
        }
      }
    },
    {
      path: '/tauler',
      name: 'tauler',
      component: () => import('../views/FO/Tauler.vue'),
      meta: { usuariAutenticat: true }
    },
    {
      path: '/cursos',
      name: 'cursos',
      component: () => import('../views/FO/Cursos.vue'),
      meta: { usuariAutenticat: true }
    },
    {
      path: '/curs/:id',
      name: 'curs-detall',
      component: () => import('../views/FO/detailsPages/CursDetall.vue'),
      meta: { usuariAutenticat: true },
      props: true
    },

    //Rutes de BACK OFFICE:
    {
      path: '/gestio',
      component: () => import('../views/BO/IndexBackoffice.vue'),
      meta: { accessGestio: true }
    },
    {
      path: '/tests',
      component: () => import('../views/Test.vue')
    },
    {
      path: '/gestio/cursos',
      component: () => import('../views/BO/cursos/GestioCursos.vue'),
      meta: { accessGestio: true }
    },
  ]
});

router.beforeEach((to, from, next) => {
  const userStore = useUserStore()
  let entra = false;

  //Guarda Logged In
  if (to.matched.some(record => record.meta.usuariAutenticat)) {
    entra = true;
    if (userStore.isLogged) {
      next();
    } else {
      next({ name: 'login' })
    }
  }

  //Guarda gestió BackOffice
  if (to.matched.some(record => record.meta.accessGestio)) {
    entra = true;
    if (userStore.canAccessGestio) {
      next();
    } else {
      next({ name: 'tauler' })
    }
  }

  if (!entra) {
    next();
  }
  
});


export default router
