<template>
<div>
	<l-carousel :data="carousel"/>
	
	<div v-if="status==='loading'" class="notes info">
		<h2><i class="fas fa-spinner fa-spin"></i> Getting information...</h2>
	</div>

	<div v-else-if="status==='error'" class="notes danger">
		<h2>An error occured</h2>
		<b @click="getCategory()">Try again</b>
	</div>	

	<div v-else class="category-container">
		<div v-for="category in categories" class="category-item shadow">
			<a :href="config.baseurl+'storage/'+category.image">
				<img :src="config.baseurl+'storage/'+category.image" height="256" width="256" />
			</a>

			<hr/>

			<div>
				<span>{{ category.name }}</span>
				<router-link :to="{name: 'user-song', params:{id: category.id}}" class="right">View Songs</router-link>
			</div>
		</div>
	</div>


</div>
</template>

<style>
.category-container{
	display: flex;
	flex-wrap: wrap;
}

.category-item{
	border-radius: 5px;
	margin: 5px;
	padding: 5px;
}
</style>

<script>
export default {
	data: ()=>({
		carousel: [],
		status: 'loading'
	}),

	created: function () {
		console.log(this)
		this.carousel = [
			{image: this.config.baseurl+'images/slide1.png'},
			{image: this.config.baseurl+'images/slide2.png'},
			{image: this.config.baseurl+'images/slide3.png'}
		]

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