<template>
<div>
	<nav class="navbar">
		<div class="navbar-left">
			<router-link class="navbar-item" :to="{name:'user-home'}" active-class="active1" exact>Home</router-link>
			<router-link class="navbar-item" :to="{name:'user-category'}" active-class="active1">Categories</router-link>
			<router-link class="navbar-item" :to="{name:'user-about'}" active-class="active1">About Us</router-link>
		</div>
	</nav>

	<div>
		<router-view></router-view>
	</div>
</div>
</template>
