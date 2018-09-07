<template>
<div class="columns is-centered">
	<div class="box login-form column is-two-thirds">
		<h4>Admin Login</h4>
		<hr/>


		<form class="column" @submit.prevent="login">

			<div class="field">
				<label class="label" for="email">E-mail</label>
				<div class="control has-icons-left" :class="{'is-loading':loading}">
					<input type="email" v-model="email" class="input" required/>
					<span class="icon is-small is-left">
						<i class="fas fa-at"></i>
					</span>
				</div>
			</div>

			<div class="field">
				<label class="label" for="password">Password</label>
				<div class="control has-icons-left" :class="{'is-loading':loading}">
					<input type="password" v-model="password" class="input" required/>
					<span class="icon is-small is-left">
						<i class="fas fa-lock"></i>
					</span>
				</div>
			</div>			

			<div class="field">
				<input type="submit" class="button is-info" value="Submit" :disabled="loading"/>
				<input type="button" class="button" value="Back to Home" :disabled="loading"/>
			</div>

		</form>

	</div>
</div>
</template>

<script>
export default{
	data: () => ({
		loading: false,
		email: '',
		password: ''
	}),

	created: function () {
		this.log(this);
	},

	methods: {
		login: function () {
			if (this.loading) return;
			this.loading = true;

			let data = this.getData();
			
			axios.post(this.config.baseurl+'api/v1/user/login', data)
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error));


		},

		success: function (response) {
			this.loading = false;
			this.log(response);

			//Show notifications
			this.$l.notify('Success', 'Login successfully', 'success');
			
			//Set token for future http request
			this.$l.setToken(response.data.token);

			//Navigate to admin panel
			this.$router.push({name:'admin-home'});
		},

		failed: function (error) {
			this.loading = false;
			this.log(error);
			if (error.response.status === 401)
				this.$l.notify('Login Failed', 'Wrong user or password!', 'error'); 
			else
				this.$l.handleError(error);
		},

		getData: function () {
			let data = new FormData();
			data.append('email', this.email);
			data.append('password', this.password);
			return data;
		}
	}
}
</script>