import { createApp } from 'vue'
import App from '@/App.vue'
import router from '@/router'
import store from '@/store'
import VueSweetalert2 from "vue-sweetalert2";
import Swal from "sweetalert2/dist/sweetalert2.js"; //importado javascript da biblioteca base
import "sweetalert2/dist/sweetalert2.min.css"; //configura css
import "./styles/index";
require('./config/axiosConfig');

var Vue = createApp(App);

Vue.use(store);
Vue.use(router);
Vue.use(VueSweetalert2);

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    timer: 10000,
    timerProgressBar: true,
    showConfirmButton: false
});
window.Toast = Toast;

Vue.config.productionTip = false;

Vue.mount('#app');
