<template>
<div class="box column is-two-thirds content">
	<h4>Update Category</h4>
	<hr/>

	<form class="columns" @submit.prevent="updateCategory()" id="update_form">
		<div class="column is-one-third">
			<l-uploader file-id="image" :img-src="config.baseurl+'storage/'+category.image"/>
		</div>
		<div class="column">

			<div class="field">
				<label class="label" for="name">Name</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="category.name" id="name" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label" for="description">Description</label>
				<div class="control" :class="{'is-loading':loading}">
					<textarea class="input" v-model="category.description" id="description" style="height: 100%;"></textarea>
				</div>
			</div>

			<div class="field">
				<input type="submit" class="button is-info" value="Submit" :disabled="loading"/>
				<input type="button" class="button" value="Back" :disabled="loading" @click="$router.go(-1)"/>
			</div>

		</div>
	</form>
</div>
</template>

<script>
export default {
	data: ()=>({
		loading: false
	}),

	created: function () {
		this.log(this)
	},

	methods: {
		updateCategory: function () {
			if (this.loading) return;
			this.loading = true;
			let data = this.getData();
			let config = {headers:{'Content-Type': `multipart/form-data; boundary=${data._boundary}`}}
			axios.post(this.config.baseurl+'api/v1/category/'+this.id, data, config)
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error))
				.then(()=>{this.loading=false});
		},

		failed: function (error) {
			this.log(error);
			this.$l.handleError(error);
		},

		success: function (response) {
			this.log(response);
			this.$l.notify('Success', 'Category updated successfully.', 'success');
		},

		getData: function () {
			let image = this.getImage();
			let data = new FormData();

			data.append('name', this.category.name);
			data.append('description', this.category.description);
			data.append('_method', 'PUT');

			if (image !== false)
				data.append('image', image, image.filename);

			return data;	
		},

		getImage: function () {
			return this.$l.getFile('image');
		}
	},

	computed: {
		id: function () {
			return this.$route.params.id;
		},

		categories: function () {
			return this.$store.state.categories;
		},

		index: function () {
			let categories = this.categories;
			for (var i in categories)
				if (categories[i].id === this.id)
					return i;
			return 0;	
		},

		category:{
			get: function () {
				let categories = this.categories;
				return categories[this.index];
			},

			set: function(category) { 
				this.$store.commit('updateCategory', category, index);
			}
		}
	}
}
</script>

