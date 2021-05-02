import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'

import 'bootstrap/dist/css/bootstrap.min.css'

import izitoast from 'izitoast'

import 'izitoast/dist/css/iziToast.min.css'

window.toast = (type, msg) => {
    let typeCapitalize = type.charAt(0).toUpperCase() + type.slice(1);
    let position = type == 'warning' ? 'topRight' : 'bottomRight';
    izitoast[type]({ title: typeCapitalize, message: msg, position })
}

let _axios = axios.create({
    baseURL: `http://localhost:8000/api/`
})

const token = localStorage.getItem('access_token')
if (token) _axios.defaults.headers.common['Authorization'] = 'Bearer ' + token

window.axios = _axios

createApp(App).use(store).use(router).mount('#app')