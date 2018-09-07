<template>
<div class="box column is-two-thirds content">

	<h4>Songs</h4>
	<hr/>

	<!--Buttons -->
	<div class="field is-grouped">
		<div class="control">
			<router-link :to="{name: 'admin-song-add'}" class="button is-success">
				<span class="icon is-small">
					<i class="fas fa-plus"></i>
				</span>
				<span>Add Song</span>
			</router-link>
		</div>

		<div class="control">
			<div class="select is-primary">
				<select v-model="category">
					<option :value="0">All Category</option>
					<option v-for="category in categories" :value="category.id">{{ category.name }}</option>
				</select>
			</div>
		</div>

		<div class="control">
			<a class="button" :disabled="status==='loading'" >
				<span class="icon is-small">
					<i class="fas fa-spinner" :class="{'fa-spin': status==='loading'}"></i>
				</span>
				<span>Refresh</span>
			</a>
		</div>
	</div>

	<!-- Table -->
	<table class="table is-striped">
		<thead>
			<tr>
				<th width="64"></th>
				<th>Title</th>
				<th>Singer</th>
				<th>Composer</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<!-- If Loading -->
			<tr v-if="status==='loading'">
				<td colspan="5" class="center">
					<i class="fas fa-spinner fa-spin"></i> Loading...
				</td>
			</tr>

			<!-- If error -->
			<tr v-else-if="status==='error'">
				<td colspan="5" class="center">
					An error occured
				</td>
			</tr>

			<!-- If deleting -->
			<tr v-else-if="status==='deleting'">
				<td colspan="5" class="center">
					<i class="fas fa-spinner fa-spin"></i> Deleting...
				</td>
			</tr>

			<!-- if no data -->
			<tr v-else-if="songs.length < 1">
				<td colspan="5" class="center">
					No songs
				</td>
			</tr>

			<tr v-for="song in songs" v-else>
				<td>
					<figure class="image is-64x64">
						<img :src="config.baseurl+'storage/'+song.image" class="img-64px"/>
					</figure>
				</td>
				<td>{{ song.title }}</td>
				<td>{{ song.singer }}</td>
				<td>{{ song.composer }}</td>
				<td>
					<p class="buttons">
						<router-link :to="{name:'admin-song-update', params:{id:song.id}}" class="button is-primary">
							<span class="icon">
								<i class="fas fa-edit"></i>
							</span>
							<span>Update</span>
						</router-link>
						<a class="button is-danger is-outlined" @click="deleteSong(song.id)">
							<span>Delete</span>
							<span class="icon is-small">
								<i class="fas fa-times"></i>
							</span>
						</a>						
					</p>
				</td>				
			</tr>

		</tbody>
	</table>

	<div class="pagination" role="navigation" aria-label="pagination" v-if="last_page > 1">
		<a class="pagination-previous" :disabled="current_page==1" @click="current_page--">Previous</a>
		<a class="pagination-next" :disabled="current_page==last_page" @click="current_page++">Next</a>
		<ul class="pagination-list ul-no-style">
			<li v-for="page in last_page">
				<a @click="current_page=page" class="pagination-link" :class="{'is-current':page==current_page}">{{ page }}</a>
			</li>
		</ul>
	</div>


</div>
</template>

<script>
export default{
	data: ()=>({
		status: 'loading',
		category: 0,
		last_page: 0
	}),

	created: function () {
		this.getSongs();
	},

	watch: {
		category: function (val) {
			this.getSongs();
		},

		'$route.query.page': function(val) {
			this.getSongs();
		}
	},

	methods: {

		deleteSong: function (id) {
			this.status = 'deleting';
			axios.delete(this.config.baseurl+'api/v1/song/'+id+'?page='+this.current_page)
				.then((response)=>{
					this.success({data:this.categories}, response);
					this.$l.notify('Success', 'Song deleted successfully','success');
				})
				.catch((error)=>this.failed(error));
		},

		getSongs: function () {
			this.status = 'loading';
			axios.all([
					axios.get(this.config.baseurl+'api/v1/category'),
					axios.get(this.getLink()+'?page='+this.current_page)
				])
				.then(axios.spread((categoryRes, songRes)=>this.success(categoryRes, songRes)))
				.catch((error)=>this.failed(error))

		},

		success: function (categoryRes, songRes) {
			this.status = 'sucess';
			this.log([categoryRes, songRes]);
			this.categories = categoryRes.data;
			this.songs = songRes.data.data;
			this.last_page = songRes.data.last_page;
		},

		failed: function (error) {
			this.status = 'error';
			this.log(error);
			this.$l.handleError(error);
		},

		getLink: function () {
			if (this.category === 0)
				return this.config.baseurl+'api/v1/song';
			else 
				return this.config.baseurl+'api/v1/category/'+this.category+'/songs';
		}
	},

	computed: {
		categories: {
			get: function () {
				return this.$store.state.categories;
			},

			set: function (categories) {
				this.$store.commit('categories', categories);
			}
		},

		songs: {
			get: function () {
				return this.$store.state.songs;
			},

			set: function (songs) {
				this.$store.commit('songs', songs);
			}
		},

		current_page: {
			get: function () {
				return this.$route.query.page ? this.$route.query.page : 1;
			},

			set: function (val) {
				this.$router.replace({query:{page:val}});
			}
		}
	}
}
</script>