<template>
<div class="page">
	<div v-if="status=='loading'" class="notes info">
		<h1><i class="fas fa-spinner fa-spin"></i> Loading...</h1>
	</div>

	<div v-else-if="status=='error'" class="notes danger">
		<h1>An error occured, click <b @click="getSong()">here</b> to refresh.</h1>
	</div>

	<div v-else class="row">
		<div class="col-md-3">
			<img :src="config.baseurl+'storage/'+song.image" height="256" width="256"/>
			<audio controls width="256" :src="config.baseurl+'storage/'+song.music"></audio>
			<br/>
			<b>Category : </b>{{ category.name }}<br/>
			<b>Singer : </b>{{ song.singer }}<br/>
			<b>Composer : </b>{{ song.composer }}
		</div>
		<div class="col-md-8">
			<h1><b>"{{ song.title }}"</b></h1>
			<hr/>
			<p class="center" v-html="lyrics"></p>
		</div>
	</div>
</div>
</template>

<script>
export default{
	data:()=>({
		status: 'loading',
		song: {},
		category: {}
	}),

	created: function () {
		this.getSong();
	},

	methods: {
		getSong: function () {
			this.status = 'loading';
			axios.all([
					axios.get(this.config.baseurl+'api/v1/category/'+this.category_id),
					axios.get(this.config.baseurl+'api/v1/song/'+this.id)
				])
				.then(axios.spread((categoryRes, songRes)=>this.success(categoryRes, songRes)))
				.catch((error)=>this.failed(error));
		},

		success: function (categoryRes, songRes) {
			this.status = 'success';
			this.log([categoryRes, songRes]);
			this.category = categoryRes.data;
			this.song = songRes.data;
		},

		failed: function (error) {
			this.status = 'error';
			this.log(error);
		}
	},

	computed: {
		id: function () {
			return this.$route.params.id;
		},

		category_id: function () {
			return this.$route.params.category_id;
		},

		lyrics: function () {
			return this.$l.lineBreak(this.song.lyrics);
		}
	}
}
</script>
