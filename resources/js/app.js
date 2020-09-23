require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
const token = document.head.querySelector('meta[name="csrf-token"]')
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/ja'

Vue.use(ElementUI, { locale })

Vue.component('level-component', require('./components/LevelComponent.vue').default);
Vue.component('quizstatus-component', require('./components/QuizStatusComponent.vue').default);
Vue.component('category-component', require('./components/CategoryComponent.vue').default);

const app = new Vue({
    el: '#app',
});