//My Own/Custom/Utility Plugin 
import VueL from './plugins/musichub/app.js'; 

import App from './pages/app.vue';

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
