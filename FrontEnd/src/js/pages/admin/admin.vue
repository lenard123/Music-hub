<template>
<div>
	<div v-if="!loading">
		<nav class="navbar is-light">
			<div class="navbar-brand">
				<a class="navbar-item" @click="router.push({path:'/admin'})">
					<img :src="config.icon" alt="MusicHub" width="28" height="28"/>
				</a>
				<a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false" :class="{'is-active':burger_active}" @click="burger_active=!burger_active">
			      <span aria-hidden="true"></span>
			      <span aria-hidden="true"></span>
			      <span aria-hidden="true"></span>
			    </a>
			</div>
			<div class="navbar-menu" id="navMenu" :class="{'is-active':burger_active}">
				<div class="navbar-start">
					<router-link :to="{name: 'admin-home'}" class="navbar-item" exact>Home</router-link>
					<router-link :to="{name: 'admin-category'}" class="navbar-item">Category</router-link>
					<router-link :to="{name: 'admin-song'}" class="navbar-item">Songs</router-link>
				</div>
				<div class="navbar-end">
					<a class="dropdown navbar-item" :class="{'is-active':is_active, 'active':$route.name=='admin-user-update'||$route.name=='admin-user-manage'}" @click="is_active=!is_active">
						<div class="dropdown-trigger">
							<div aria-haspopup="true" aria-controls="dropdown-menu">
								<span class="icon">
									<figure class="image is-24x24">
										<img :src="config.baseurl+'storage/'+user.image" height="24" width="24" class="is-rounded" style="margin-top:25%;" />
									</figure> 
								</span>
								<span> {{ user.name }}</span>
								<span class="icon is-small">
									<i class="fas fa-angle-down" aria-hidden="true"></i>
								</span>
							</div>
						</div>
						<div class="dropdown-menu" id="dropdown-menu" role="menu">
							<div class="dropdown-content">
								<router-link :to="{name:'admin-user-update'}" active-class="is-active" class="dropdown-item">Update Account</router-link>
								<router-link :to="{name:'admin-user-manage'}" active-class="is-active" class="dropdown-item" v-if="user.id==1">Manage Users</router-link>
								<a class="dropdown-item" @click="logout()">Logout</a>
							</div>
						</div>
					</a>
				</div>
			</div>

		</nav>
		<div class="columns is-centered">
			<router-view></router-view>
		</div>
	</div>
	<div v-else-if="error" class="container is-fluid main-loading">
		<div class="notification">
			<h1><i class="fas fa-spinner fa-spin"></i> Loading...</h1>
		</div>		
	</div>

	<div v-else class="container is-fluid main-loading">
		<div class="notification">
			<h1><i class="fas fa-spinner fa-spin"></i> Loading...</h1>
		</div>
	</div>
</div>
</template>



<script>
export default{
	data: ()=>({
		error: false,
		loading: true,
		is_active: false,
		burger_active: false
	}),

	created: function() {
		this.$l.setAuthorization();
		this.chkLogin();
	},

	computed: {
		user: function () {
			return this.$store.state.user;
		}
	},

	methods: {

		chkLogin: function () {
			axios.get(this.config.baseurl+'api/user')
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error));
		},

		success: function(response) {
			this.loading = false;
			this.log(response);
			this.$store.commit('user', response.data);
		},

		failed: function(error) {
			this.log(error);
			if (error.response.status === 401) {
				this.$l.notify('Failed', 'You need to login first.', 'error');
				this.logout();
			}
		},

		logout: function () {
			localStorage.clear();
			this.$store.dispatch('clearData');
			this.$l.setAuthorization();
			this.$router.push({name:'admin-login'});
		}
	}
}
</script>