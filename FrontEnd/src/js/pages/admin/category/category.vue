<template>
<div class="box column is-two-thirds content">

	<h4>Categories</h4>
	<hr/>

	<!--Buttons -->
	<div class="field is-grouped">
		<p class="control">
			<router-link :to="{name:'admin-category-add'}" class="button is-success">
				<span class="icon is-small">
					<i class="fas fa-plus"></i>
				</span>
				<span>Add Category</span>
			</router-link>
		</p>
		<p class="control">
			<a class="button" :disabled="status==='loading'" @click="getCategories()">
				<span class="icon is-small">
					<i class="fas fa-spinner" :class="{'fa-spin': status==='loading'}"></i>
				</span>
				<span>Refresh</span>
			</a>
		</p>
	</div>

	<!-- Table -->
	<table class="table is-striped">
		<thead>
			<tr>
				<th width="64"></th>
				<th>Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<!-- If Loading -->
			<tr v-if="status==='loading'">
				<td colspan="3" class="center">
					<i class="fas fa-spinner fa-spin"></i> Loading...
				</td>
			</tr>

			<!-- If error -->
			<tr v-else-if="status==='error'">
				<td colspan="3" class="center">
					An error occured
				</td>
			</tr>

			<!-- If deleting -->
			<tr v-else-if="status==='deleting'">
				<td colspan="3" class="center">
					<i class="fas fa-spinner fa-spin"></i> Deleting...
				</td>
			</tr>

			<!-- if no data -->
			<tr v-else-if="categories.length < 1">
				<td colspan="3" class="center">
					No categories
				</td>
			</tr>

			<tr v-for="category in categories" v-else>
				<td>
					<figure class="image is-64x64">
						<img :src="config.baseurl+'storage/'+category.image" class="img-64px"/>
					</figure>
				</td>
				<td>{{ category.name }}</td>
				<td>
					<p class="buttons">
						<a class="button is-primary" @click="$router.push({name:'admin-category-update', params:{id:category.id}})">
							<span class="icon">
								<i class="fas fa-edit"></i>
							</span>
							<span>Update</span>
						</a>
						<a class="button is-danger is-outlined" @click="deleteCategory(category.id)">
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

</div>
</template>

<script>
export default{

	data: ()=>({
		status: 'loading'
	}),

	created: function () {
		this.getCategories();
	},

	methods: {
		getCategories: function () {
			this.status = 'loading';
			axios.get(this.config.baseurl+'api/v1/category')
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error));
		},

		deleteCategory: function (id) {
			this.status = 'deleting';
			axios.delete(this.config.baseurl+'api/v1/category/'+id)
				.then((response)=>this.success(response, true))
				.catch((error)=>this.failed(error));
		},

		success: function (response, is_delete=false) {

			this.log(response);
			if (is_delete)
				this.$l.notify('Success', 'Category deleted successfully', 'success');
			this.status = 'success';
			this.categories = response.data;
		},

		failed: function (error) {
			this.log(error);

			if (error.response.status == 591) {
				this.status = 'success';
				this.$l.notify('Failed', error.response.data, 'error');
				this.$l.notify('Note', 'Make sure that there\'s no song before deleting the category.','warn');
			} else {
				this.status = 'error';
				this.$l.handleError(error);
			}
		}
	},

	computed: {
		categories: {
			get: function () {
				return this.$store.state.categories;
			},

			set: function(categories) {
				this.$store.commit('categories', categories);
			}
		}
	}
}
</script>
