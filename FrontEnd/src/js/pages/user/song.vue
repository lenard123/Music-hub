<template>
<div class="page">
	<div v-if="status=='loading'" class="notes info">
		<h1><i class="fas fa-spinner fa-spin"></i> Loading...</h1>
	</div>

	<div v-else-if="status=='error'" class="notes danger">
		<h1>An error occured, click <b @click="getSongs()">here</b> to refresh.</h1>
	</div>
	
	<div v-else class="row">
		<div class="col-md-3">
			<img :src="config.baseurl+category.image" height="256" width="256s"/><br/>
			<b>Name : </b>{{ category.name }}<br/>
			<b>Description :</b> <span class="text-wrap">{{ category.description }}</span>
		</div>
		<div class="col-md-8">
			
			<h1>Songs</h1>
			<hr/>

			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th>Title</th>
						<th>Singer</th>
						<th>Composer</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="songs.length < 1" class="center">
						<td colspan="5">No songs</td>
					</tr>

					<tr v-else v-for="song in songs">
						<td><img :src="config.baseurl+'storage/'+song.image" height="64" width="64" class="img-circle"/></td>
						<td>{{ song.title }}</td>
						<td>{{ song.singer }}</td>
						<td>{{ song.composer }}</td>
						<td><router-link :to="{name: 'user-lyrics', params:{category_id:id, id:song.id}}">Play</router-link></td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</div>
</template>

<script>
export default{
	data:()=>({
		status: 'loading',
		category: {},
		songs: [],
		last_page: 0
	}),

	created: function () {
		this.getSongs();
	},

	methods: {
		getSongs: function () {
			this.status = 'loading';
			axios.all([
					axios.get(this.config.baseurl+'api/v1/category/'+this.id),
					axios.get(this.config.baseurl+'api/v1/category/'+this.id+'/songs')
				])
				.then(axios.spread((categoryRes, songRes)=>this.success(categoryRes, songRes)))
				.catch((error)=>this.failed(error));
		},

		failed: function (error) {
			this.status = 'error';
			this.log(error);
		},

		success: function (categoryRes, songRes) {
			this.status = 'success';
			this.log([categoryRes, songRes]);
			this.category = categoryRes.data;
			this.songs = songRes.data.data;
			this.last_page = songRes.data.last_page;
		}
	},

	computed: {
		id: function () {
			return this.$route.params.id;
		},

		current_page: {
			get: function () {
				return this.$route.query.page ? this.$route.query.page:1;
			},

			set: function (page) {
				this.$router.replace({query:{page:page}});
			}
		}
	}
}
</script>