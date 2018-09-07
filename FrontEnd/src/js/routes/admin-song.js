import song from '../pages/admin/song/song.vue';
import add from '../pages/admin/song/add.vue';
import update from '../pages/admin/song/update.vue';

export default [
	{
		path: 'song',
		component: song,
		name: 'admin-song'
	},

	{
		path: 'song/add',
		component: add,
		name: 'admin-song-add',
		beforeEnter: (to, from, next)=>{
			if (from.name !== 'admin-song')
				next({name:'admin-song'});
			next();
		}
	},

	{
		path: 'song/update/:id',
		component: update,
		name: 'admin-song-update',
		beforeEnter: (to, from, next)=>{
			if (from.name !== 'admin-song')
				next({name:'admin-song'});
			next();
		}
	}	
]