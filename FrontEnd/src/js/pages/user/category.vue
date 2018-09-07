<template>
<div class="page">
	<h1 style="margin: 0px;padding: 0px;">Categories</h1>
	<p>Below is a list of song category with description</p>
	<hr/>


	<div v-if="status=='loading'" class="notes info">
		<h1><i class="fas fa-spinner fa-spin"></i> Loading...</h1>
	</div>

	<div v-else-if="status=='error'" class="notes danger">
		<h1>An error occured, click <b @click="getCategory()">here</b> to refresh.</h1>
	</div>

	<div v-else-if="categories.length < 1" class="flex-center center">
		<span> No categories</span>
	</div>

	<div v-else v-for="category in categories" class="flex-center">

		<div class="col-md-8 row cat-item shadow">
			<div class="col-md-2">
				<div class="right">
					<a :href="config.baseurl+'storage/'+category.image" >
						<img :src="config.baseurl+'storage/'+category.image" height="128" width="128" />
					</a>
					<div>{{ category.name }}</div>
					<router-link :to="{name: 'user-song', params:{id: category.id}}">View Songs</router-link>
				</div>
			</div>
			<div class="col-md-8">
				<div class="text-wrap">{{ category.description }}</div>
			</div>
		</div>
	</div>

</div>
</template>

<style>

.cat-item {
	margin: 15px;
	padding: 15px;
}
</style>

<script>
export default{
	data:()=>({
		status:'loading'
	}),

	created: function () {
		this.getCategory();
	},

	methods: {
		getCategory: function () {
			this.status = 'loading';
			axios.get(this.config.baseurl+'api/v1/category')
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error));
		},

		success: function (response) {
			this.status = 'success';
			this.log(response);
			this.categories = response.data;
		},

		failed: function (error) {
			this.status = 'error';
			this.log(error);
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
		}
	}
}
</script>