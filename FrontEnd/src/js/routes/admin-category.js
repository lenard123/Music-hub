import category from '../pages/admin/category/category.vue';
import categoryAdd from '../pages/admin/category/add.vue';
import categoryUpdate from '../pages/admin/category/update.vue';

export default [
	{
		path: 'category',
		component: category,
		name: 'admin-category'
	},

	{
		path: 'category/add',
		component: categoryAdd,
		name: 'admin-category-add',
		beforeEnter: (to, from, next) => {
			if (from.name !== 'admin-category')
				next({name:'admin-category'});
			else next();
		}
	},

	{
		path: 'category/update/:id',
		component: categoryUpdate,
		name: 'admin-category-update',
		beforeEnter: (to, from, next) => {
			if (from.name !== 'admin-category')
				next({name: 'admin-category'});
			else next();
		}
	}
]