require('./bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/ja'
Vue.use(ElementUI, { locale })
Vue.component('level-component', require('./components/LevelComponent.vue').default);
Vue.component('quizstatus-component', require('./components/QuizStatusComponent.vue').default);

const app = new Vue({
    el: '#app',
});