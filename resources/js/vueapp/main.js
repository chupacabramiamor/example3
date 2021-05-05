import Vue from 'vue';
import axios from 'axios';
import App from './views/App';
import InputmaskDirective from './directives/inputmask';

Vue.use({
    install(Vue) {
        Vue.prototype.$axios = axios.create({
            baseUrl: '/rest'
        });
    }
});

Vue.directive('inputmask', InputmaskDirective);

var vueapp = new Vue({
    el: '#app',

    components: { App }
});
