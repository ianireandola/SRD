require('./bootstrap');

window.Vue = require('vue');
Vue.config.productionTip = false; //Para quitar esta alerta: You are running Vue in development mode. Make sure to turn on production mode when deploying for production.
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueSweetalert2 from 'vue-sweetalert2';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTimesCircle } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Popover from 'vue-js-popover'

library.add(faTimesCircle)
Vue.use(BootstrapVue)
Vue.use(VueSweetalert2)
Vue.use(Popover)
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('srd-component', require('./components/srdComponent.vue').default);
Vue.component('registrar-horas-component', require('./components/RegistroHorasComponent.vue').default);
Vue.component('registrar-horas2-component', require('./components/RegistroHoras2Component.vue').default);
Vue.component('area-component', require('./components/AreaComponent.vue').default);
Vue.component('seccion-component', require('./components/SeccionComponent.vue').default);
Vue.component('categoria-component', require('./components/CategoriaComponent.vue').default);
Vue.component('planta-component', require('./components/PlantaComponent.vue').default);
Vue.component('fijoeventual-component', require('./components/FijoEventualComponent.vue').default);
Vue.component('dedicacion-component', require('./components/DedicacionComponent.vue').default);
Vue.component('tipoproyecto-component', require('./components/TipoProyectoComponent.vue').default);
Vue.component('nacion-component', require('./components/NacionComponent.vue').default);
Vue.component('fase-component', require('./components/FaseComponent.vue').default);
Vue.component('accion2-component', require('./components/Accion2Component.vue').default);
Vue.component('adminadmin-component', require('./components/AdminAdminComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('historial-component', require('./components/HistorialComponent.vue').default);
Vue.component('historial2-component', require('./components/Historial2Component.vue').default);
Vue.component('letra-component', require('./components/LetraComponent.vue').default);
Vue.component('elemento-component', require('./components/ElementoComponent.vue').default);
Vue.component('hito-component', require('./components/HitoComponent.vue').default);
Vue.component('tipo-elemento-component', require('./components/TipoElementoComponent.vue').default);
Vue.component('avance-proyecto-component', require('./components/AvanceProyectoComponent.vue').default);
Vue.component('trabajan-component', require('./components/TrabajanComponent.vue').default);
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false

const app = new Vue({
    el: '#app',
});
