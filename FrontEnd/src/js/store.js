export default {
	state: {
		user: {},
		users: [],
		categories:[],
		songs: []
	},

	mutations: {
		user: function (state, user) {
			state.user = user;
		},

		users: function (state, users) {
			state.users = users;
		},

		categories: function (state, categories) {
			state.categories = categories;
		},

		category: function (state, category, index) {
			state.categories.splice(index, 1, category);
		},

		songs: function (state, songs) {
			state.songs = songs;
		}

	},

	actions: {
		clearData: function (context) {
			context.commit('user', {});
			context.commit('categories', []);
			context.commit('songs', []);
		}
	}
}