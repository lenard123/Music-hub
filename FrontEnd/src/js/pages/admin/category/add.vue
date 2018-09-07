<template>
<div class="box column is-two-thirds content">
	<h4>Add Category</h4>
	<hr/>

	<form class="columns" @submit.prevent="addCategory()">
		<div class="column is-one-thirds">
			<l-uploader file-name="image" file-id="image" />
		</div>
		<div class="column">

			<div class="field">
				<label class="label" for="name">Name</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="name" name="name" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label" for="description">Description</label>
				<div class="control" :class="{'is-loading':loading}">
					<textarea class="input" v-model="description" style="height: 100%;" name="description"></textarea>
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
	data: () => ({
		name: '',
		description: '',
		loading: false
	}),

	methods: {
		addCategory: function () {
			if (this.loading) return;
			this.loading = true;

			let data = this.getData();
			let config = {headers:{'Content-Type': `multipart/form-data; boundary=${data._boundary}`}}
			axios.post(this.config.baseurl+'api/v1/category', data, config)
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error))
				.then(()=>{this.loading=false})
		},

		failed: function (error) {
			this.log(error);
			this.$l.handleError(error);
		},

		success: function (response) {
			this.log(response);
			this.$l.notify('Success', 'Category added successfully', 'success');
		},

		getImage: function () {
			return this.$l.getFile('image');
		},

		getData: function () {
			let data = new FormData();
			let image = this.getImage();
			data.append('name', this.name);
			data.append('description', this.description);
			if (image !== false)
				data.append('image', image, image.filename);
			return data;
		}
	}
}
</script>