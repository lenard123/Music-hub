<template>
<div class="box column is-two-thirds content">
	<h4>Update User</h4>
	<hr/>

	<form class="columns" @submit.prevent="updateUser()">
		<div class="column is-one-thirds center">
			<l-uploader file-id="image" :img-src="config.baseurl+'storage/'+user.image" />
		</div>
		<div class="column">
			<div class="field">
				<label class="label">Name</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="user.name" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">E-mail</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="email" v-model="user.email" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Confirm E-mail</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="email" v-model="c_email" class="input" required/>
				</div>
			</div>

			<div class="field" v-if="!showpass">
				<input type="button" class="button is-primary w-max" @click="showpass=true;" value="Update Password"/>
			</div>

			<div class="field" v-if="showpass">
				<label class="label">Password</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="password" v-model="password" class="input" required/>
				</div>
			</div>

			<div class="field" v-if="showpass">
				<label class="label">Confirm Password</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="password" v-model="c_password" class="input" required/>
				</div>
			</div>

			<div class="field">
				<input type="submit" class="button is-info" value="Submit" :disabled="loading"/>
				<input type="button" class="button" value="Back" :disabled="loading" @click="$router.push({name:'admin-home'})"/>
			</div>
		</div>
	</form>			
</div>
</template>

<script>
export default{
	data:()=>({
		user: {},
		loading: false,
		showpass: false,
		c_email:'',
		c_password:'',
		password:''
	}),

	created: function () {
		this.user.name = this.user1.name;
		this.user.email = this.user1.email;
		this.user.image = this.user1.image;
		this.c_email = this.user.email;
	},

	methods: {
		updateUser: function () {
			if (this.loading) return
			if (this.user.email !== this.c_email)
				return this.$l.notify('Failed', 'E-mail doesn\'t match', 'error');
			if (this.c_password !== this.password)
				return this.$l.notify('Failed', 'Password doesn\'t match', 'error');

			this.loading = true;

			let data = this.getData();
			let config = {headers:{'Content-Type': `multipart/form-data; boundary=${data._boundary}`}}

			axios.post(this.config.baseurl+'api/v1/user', data, config)
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error))
				.then(()=>{this.loading = false});
		},

		success: function (response) {
			this.log(response);
			this.$l.notify('Success', 'User updated successfully.', 'success');
			this.user1 = response.data;
		},

		failed: function (error) {
			this.log(error);
			this.$l.handleError(error);
		},

		getData: function () {
			let image = this.$l.getFile('image');

			let data = new FormData();
			data.append('name', this.user.name);
			data.append('email', this.user.email);
			data.append('c_email', this.c_email);
			data.append('_method', 'PUT');
			if (image !== false) 
				data.append('image', image, image.name);
			if (this.showpass) {
				data.append('password', this.password);
				data.append('c_password', this.c_password);
			}

			return data;
		}
	},

	computed: {
		user1: {
			get: function () {
				return this.$store.state.user;
			},

			set: function (val) {
				this.$store.commit('user', val);
			}
		}
	}
}
</script>
