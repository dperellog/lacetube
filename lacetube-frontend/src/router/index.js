import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '@/stores/userStore';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior(to, from, savedPosition) {
    // always scroll to top
    return { top: 0 }
  },
  routes: [
    //Rutes de FRONT OFFICE:
    {
      path: '/',
      name: 'home',
      component: () => import('../views/FO/IndexPage.vue'),
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

    {
      path: '/activitat/penjar/:id',
      name: 'pujar-video',
      component: () => import('../views/FO/detailsPages/PujarVideo.vue'),
      meta: { usuariAutenticat: true },
      props: true
    },
    {
      path: '/activitat/modificar/:videoID',
      name: 'modificar-video',
      component: () => import('../views/FO/detailsPages/PujarVideo.vue'),
      meta: { usuariAutenticat: true },
      props: true
    },
    {
      path: '/videos',
      name: 'videos',
      component: () => import('../views/FO/Videos.vue'),
      meta: { usuariAutenticat: true }
    },
    {
      path: '/video/:id',
      name: 'watch',
      component: () => import('../views/FO/detailsPages/View.vue'),
      props: true
    },
    {
      path: '/usuari/:id',
      name: 'usuariDetall',
      component: () => import('../views/FO/detailsPages/UsuariDetall.vue'),
      props: true,
      meta: { usuariAutenticat: true }
    },
    {
      path: '/configuracio',
      name: 'configuracio',
      component: () => import('../views/FO/ConfiguracioUsuari.vue'),
      meta: { usuariAutenticat: true }
    },

    //Rutes de BACK OFFICE:
    {
      path: '/gestio',
      component: () => import('../views/BO/IndexBackoffice.vue'),
      meta: { accessGestio: true }
    },
    {
      path: '/gestio/usuaris',
      component: () => import('../views/BO/usuaris/GestioUsuaris.vue'),
      meta: { accessGestio: true }
    },
    {
      path: '/gestio/usuaris/crear',
      component: () => import('../views/BO/usuaris/CrearUsuaris.vue'),
      meta: { accessGestio: true }
    },
    {
      path: '/gestio/cursos',
      component: () => import('../views/BO/cursos/GestioCursos.vue'),
      meta: { accessGestio: true }
    },
    {
      path: '/gestio/cursos/crear',
      component: () => import('../views/BO/cursos/CursForm.vue'),
      meta: { accessGestio: true }
    },
    {
      path: '/gestio/cursos/modificar/:id',
      component: () => import('../views/BO/cursos/CursForm.vue'),
      props: true,
      meta: { accessGestio: true },
    },
    {
      path: '/gestio/activitats',
      component: () => import('../views/BO/activitats/GestioActivitats.vue'),
      meta: { accessGestio: true }
    },
    {
      path: '/gestio/videos',
      component: () => import('../views/BO/videos/GestioVideos.vue'),
      meta: { accessGestio: true }
    },
    {
      path: "/:pathMatch(.*)*",
      component: () => import('../views/404.vue')
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
