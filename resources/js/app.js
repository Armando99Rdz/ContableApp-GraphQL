
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'; // importar VueRouter
import VueApollo from 'vue-apollo';

import Router from './router'; // importar mi router.js
import apolloClient from "./apollo/client";



Vue.use(VueRouter); // utliza la libreria VueRouter
Vue.use(VueApollo); //

// usa mi apollo client para consultar mi GraphQL API
const apolloProvider = new VueApollo({
    defaultClient: apolloClient
})

/**
 * Intsanciar Vue
 * @type {Vue}
 */
new Vue({
    router: Router, // usa mi router.js
    apolloProvider
}).$mount('#app')
