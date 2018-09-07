require('./bootstrap');

//VueJS and other plugins
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

//Third Part Plugin for Toast Notifications
import Notification from 'vue-notification';

//My Own/Custom/Utility Plugin 
import VueL from './plugins/musichub/app.js'; 

import App from './pages/app.vue';

//Registering plugins
Vue.use(Notification);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueL, {mode:'debug'});

import routes from './routes.js';
import store from './store.js';

const router = new VueRouter({
	linkActiveClass: 'active',
	routes
});

const app = new Vue({
	created: function () {
		this.log(this)
	},
    el: '#app',
    router,
	store: new Vuex.Store(store),
	render: h => h(App)
});
