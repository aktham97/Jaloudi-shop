

import Vue from 'vue';
import Router from 'vue-router';
import Home from "./views/Home";
import * as auth from './services/auth_service'

Vue.use(Router);

const routes = [
    {
        path:'/home',
        component:Home,
        children:[
            {
                path:'',
                name:'welcome',
                component:() => import('./views/Welcome.vue')
            },
            {
                path:'/Men/Shirts',
                name:'men-shirts',
                component: () => import('./views/men/Shirts.vue')
            },
            {
                path:'/Men/Pants',
                name:'men-pants',
                component: () => import('./views/men/Pants.vue')
            },
            {
                path:'/Men/Jackets',
                name:'men-jackets',
                component: () => import('./views/men/Jackets')
            },
            {
                path:'/Women/Pants',
                name:'women-pants',
                component: () => import('./views/women/Pants.vue')
            },
            {
                path:'/Women/Jackets',
                name:'women-jackets',
                component: () => import('./views/women/Jackets')
            },
            {
                path:'/Women/Dresses',
                name:'women-dresses',
                component: () => import('./views/women/Dresses')
            }
        ],
        beforeEnter(to,from,next)
        {
            if(!auth.isLoggedIN())
            {
                next('/login');
            }else
            {
                next();
            }
        }
    },

    {
        path: '/register',
        name:'register',
        component: () => import('./views/authentication/Register.vue')
    },
    {
        path: '/login',
        name:'login',
        component: () => import('./views/authentication/Login.vue'),
        beforeEnter(to,from,next)
        {
            if(!auth.isLoggedIN())
            {
                next();
            }else
            {
                next('/home');
            }
        }
    },
    {
        path: '',
        name:'startPage',
        component: () => import('./views/StartPage.vue'),
        // beforeEnter(to,from,next)
        // {
        //     if(!auth.isLoggedIN())
        //     {
        //         next();
        //     }else
        //     {
        //         next('/home');
        //     }
        // }
    },
    {
        path: '/test',
        name:'test',
        component: () => import('./views/test.vue'),
        // beforeEnter(to,from,next)
        // {
        //     if(!auth.isLoggedIN())
        //     {
        //         next();
        //     }else
        //     {
        //         next('/home');
        //     }
        // }
    }
];

const router = new Router({
    mode:'history',
   routes:routes
});

export default router;
