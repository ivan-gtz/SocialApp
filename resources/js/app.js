/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

window.EventBus = new Vue();

Vue.component('status-form', require('./components/StatusForm.vue').default);
Vue.component('status-list', require('./components/StatusList.vue').default);
Vue.component('status-list-item', require('./components/StatusListItem.vue').default);
Vue.component('friendship-btn', require('./components/FriendshipBtn.vue').default);
Vue.component('accept-friendship-btn', require('./components/AcceptFriendshipBtn.vue').default);
Vue.component('notification-list', require('./components/NotificationList.vue').default);


import auth from './mixins/auth';


Vue.mixin(auth);

const app = new Vue({
    el: '#app',
});
