import update from '../pages/admin/user/update.vue';
import manage from '../pages/admin/user/manage.vue';
import add from '../pages/admin/user/add.vue';

export default [
	{
		path: 'user/update',
		component: update,
		name: 'admin-user-update'
	},

	{
		path: 'user/manage',
		component: manage,
		name: 'admin-user-manage'
	},

	{
		path: 'user/add',
		component: add,
		name: 'admin-user-add',
		beforeEnter: (to, from, next)=>{
			if (from.name !== 'admin-user-manage')
				next({name: 'admin-user-manage'});
			next();
		}
	}
]