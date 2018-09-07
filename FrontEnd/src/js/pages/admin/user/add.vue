<template>
<div class="box column is-two-thirds content">
	<h4>Update User</h4>
	<hr/>

	<form class="columns" @submit.prevent="addUser()">
		<div class="column is-one-thirds center">
			<l-uploader file-id="image" />
		</div>
		<div class="column">
			<div class="field">
				<label class="label">Name</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="name" class="input" required/>
				</div>
			</div>


			<div class="field">
				<label class="label">E-mail</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="email" v-model="email" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Config E-mail</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="email" v-model="c_email" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Password</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="password" v-model="password" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Confirm Password</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="password" v-model="c_password" class="input" required/>
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
export default{
	data:()=>({
		loading: false,
		name:'',
		email:'',
		c_email:'',
		password:'',
		c_password:''
	}),

	methods: {
		addUser: function () {
			if (this.loading) return;
			else if (this.email !== this.c_email) return this.$l.notify('Failed', 'Email doesn\'t match', 'warn');
			else if (this.password !== this.c_password) return this.$l.notify('Failed', 'Password doesn\'t match', 'warn');
			this.loading = true;

			let data = this.getData();
			let config = {headers:{'Content-Type': `multipart/form-data; boundary=${data._boundary}`}}

			axios.post(this.config.baseurl+'api/v1/user', data, config)
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error))
				.then(()=>{this.loading=false});
		},

		success: function (response) {
			this.log(response);
			this.$l.notify('Success', 'User added successfully', 'success');
		},

		failed: function (error) {
			this.log(error);
			this.$l.handleError(error);
		},

		getData: function () {
			let data = new FormData();
			let image = this.$l.getFile('image');
			data.append('name', this.name);
			data.append('email', this.email);
			data.append('password', this.password);
			data.append('c_email', this.c_email);
			data.append('c_password', this.c_password);
			if (image !== false)
				data.append('image', image);
			return data;
		}
	}
}
</script>