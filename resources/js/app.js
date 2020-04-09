/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window._ = require('lodash');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);
Vue.component('student-invitation-dialog', require('./components/teachers/StudentInvitationDialog').default);
Vue.component('flash', require('./components/FlashSnackBar').default);
Vue.component('dictionary', require('./components/dictionary/Dictionary.vue').default);
Vue.component('chat', require('./components/messages/Chat.vue').default);

/**
 * Material Design Components
 */
import {MdApp,
    MdToolbar,
    MdDrawer,
    MdButton,
    MdContent,
    MdTabs,
    MdIcon,
    MdList,
    MdCard,
    MdAvatar,
    MdDivider,
    MdTable,
    MdField,
    MdDialog,
    MdProgress,
    MdSnackbar,
    MdAutocomplete,
    MdSpeedDial,
    MdMenu,
    } from 'vue-material/dist/components'

Vue.use(MdApp);
Vue.use(MdToolbar);
Vue.use(MdDrawer);
Vue.use(MdButton);
Vue.use(MdContent);
Vue.use(MdTabs);
Vue.use(MdIcon);
Vue.use(MdList);
Vue.use(MdCard);
Vue.use(MdAvatar);
Vue.use(MdDivider);
Vue.use(MdTable);
Vue.use(MdField);
Vue.use(MdDialog);
Vue.use(MdProgress);
Vue.use(MdSnackbar);
Vue.use(MdAutocomplete);
Vue.use(MdSpeedDial);
Vue.use(MdMenu);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
