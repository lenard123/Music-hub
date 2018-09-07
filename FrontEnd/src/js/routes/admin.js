import login from '../pages/admin/login.vue';
import admin from '../pages/admin/admin.vue';

import category from './admin-category.js'
import song from './admin-song.js';
import user from './admin-user.js';

export default [
	{
		path: '',
		component: admin,
		beforeEnter: (to, from, next) => {
			if (localStorage['token'] === undefined)
				next({name: 'admin-login'});
			else next();
		},
		children: [
			{
				path: '',
				component: {template:'<div>Home</div>'},
				name: 'admin-home'
			}
		].concat(category)
		 .concat(song)
		 .concat(user)

	},

	{
		path: 'login',
		component: login,
		name: 'admin-login',
		beforeEnter: (to, from, next) => {
			if (localStorage['token'] !== undefined)
				next({name:'admin-home'});
			else next();
		}
	}
]
