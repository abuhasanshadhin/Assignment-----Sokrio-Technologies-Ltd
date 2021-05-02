import { createRouter, createWebHistory } from 'vue-router'

function guard(to, from, next) {
  let token = localStorage.getItem('access_token')

  if (!token) {
    next('/')
  } else {
    next()
  }
}

const routes = [
  {
    path: '/',
    name: 'Login',
    component: () => import(/* webpackChunkName: "login" */ '../views/Login.vue')
  },
  {
    path: '/dashboard',
    name: 'Layout',
    component: () => import(/* webpackChunkName: "dashboard" */ '../views/Layout.vue'),
    beforeEnter: guard,
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import(/* webpackChunkName: "branch" */ '../views/Dashboard.vue')
      },
      {
        path: '/branch',
        name: 'Branch',
        component: () => import(/* webpackChunkName: "branch" */ '../views/Branch.vue')
      },
      {
        path: '/employee',
        name: 'Employee',
        component: () => import(/* webpackChunkName: "employee" */ '../views/Employee.vue')
      },
      {
        path: '/attendance',
        name: 'Attendance',
        component: () => import(/* webpackChunkName: "attendance" */ '../views/Attendance.vue')
      },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
