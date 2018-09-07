import user from '../pages/user/user.vue';
import home from '../pages/user/home.vue';
import category from '../pages/user/category.vue';
import song from '../pages/user/song.vue';
import lyrics from '../pages/user/lyrics.vue';
import about from '../pages/user/about.vue';

export default [
	{
		path: '',
		component: user,
		children: [
			{
				path: '',
				component: home,
				name: 'user-home'
			},

			{
				path: 'category',
				component: category,
				name: 'user-category'
			},

			{
				path: 'category/:id',
				component: song,
				name: 'user-song'
			},

			{
				path: 'category/:category_id/:id',
				component: lyrics,
				name: 'user-lyrics'
			},

			{
				path: 'about',
				component: about,
				name: 'user-about'
			}
		]
	}
]
