import adminRoutes from './routes/admin.js';
import userRoutes from './routes/user.js';
import admin from './pages/admin.vue';
import user from './pages/user.vue';

const routes = [
	{
		path: '/admin',
		component: admin,
		children: adminRoutes
	},

	{
		path: '/',
		component: user,
		children: userRoutes
	}
]

export default routes;
