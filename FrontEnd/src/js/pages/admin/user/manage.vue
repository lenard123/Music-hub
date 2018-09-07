<template>
<div class="box column is-two-thirds content">
	
	<h4>Manage User</h4>
	<hr/>

	<!--Buttons -->
	<div class="field is-grouped">
		<p class="control">
			<router-link to="add" class="button is-success">
				<span class="icon is-small">
					<i class="fas fa-plus"></i>
				</span>
				<span>Add User</span>
			</router-link>
		</p>
		<p class="control">
			<a class="button" :disabled="status==='loading'" @click="getUsers()">
				<span class="icon is-small">
					<i class="fas fa-spinner" :class="{'fa-spin': status==='loading'}"></i>
				</span>
				<span>Refresh</span>
			</a>
		</p>
	</div>

	<table class="table is-striped">
		<thead>
			<th width="64"></th>
			<th>Name</th>
			<th>E-mail</th>
			<th>Delete</th>
		</thead>
		<tbody>
			<!-- If Loading -->
			<tr v-if="status=='loading'">
				<td colspan="4" class="center">
					<span><i class="fas fa-spinner fa-spin"></i> Loading...</span>
				</td>
			</tr>

			<!-- If error -->
			<tr v-else-if="status=='error'">
				<td colspan="3" class="center">
					<span>An error occured</span>
				</td>
			</tr>

			<!-- If deleting -->
			<tr v-else-if="status==='deleting'">
				<td colspan="4" class="center">
					<span><i class="fas fa-spinner fa-spin"></i> Deleting...</span>
				</td>
			</tr>

			<!-- if no data -->
			<tr v-else-if="users.length < 1">
				<td colspan="4" class="center">
					<span>No users</span>
				</td>
			</tr>

			<!-- if success -->
			<tr v-else v-for="user in users">
				<td>
					<figure class="image is-64x64">
						<img :src="config.baseurl+'storage/'+user.image" class="img-64px"/>
					</figure>
				</td>
				<td>{{ user.name }}</td>
				<td>{{ user.email }}</td>
				<td>
					<button class="button is-danger is-outlined" :disabled="user.id==1">
						<span>Delete</span>
						<span class="icon is-small">
							<i class="fas fa-times"></i>
						</span>
					</button>
				</td>
			</tr>

		</tbody>
	</table>
</div>

</template>

<script>
export default{
	data:()=>({
		status: 'loading'
	}),

	created: function () {
		this.getUsers();
	},

	methods: {
		getUsers: function () {
			this.status ='loading';
			axios.get(this.config.baseurl+'api/v1/user')
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error));
		},

		success: function (response) {
			this.status = 'success';
			this.log(response);
			this.users = response.data;
		},

		failed: function (error) {
			this.status = 'error';
			this.log(error);
			this.$l.handleError(error);
		}
	},

	computed: {
		users: {
			get: function () {
				return this.$store.state.users;
			},

			set: function (users) {
				this.$store.commit('users', users);
			}
		}
	}
}
</script>