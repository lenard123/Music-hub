<template>
<div class="panel page">
	<h1>About Us</h1>
	<hr/>

		<div class="team-container">
			<div class="team-item" v-for="item in config.team">
				<center style="background-color: black;">
					<img :src="config.baseurl+'storage/'+item.image" :alt="item.name" style="width: auto; height: 200px;" />
				</center>
				<div class="team-desc">
					<h2>{{ item.name }}</h2>
					<p style="color: grey;">{{ item.role }}</p>
					<p><i>"{{ item.description }}"</i></p>
					<p>{{ item.contact }}</p>
					<p><button class="team-button">Contact</button></p>
				</div>
			</div>
		</div>

</div>
</template>


<style>
.panel{
	border: 1px solid black;
	padding: 15px;
	border-radius: 5px;
}

.team-container{
	display: flex;
	justify-content: space-evenly;
	flex-wrap: wrap;
}

.team-item {
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	min-width: 350px;
	margin-bottom: 20px;
}

.team-desc{
  padding: 5px 16px;
}

.team-desc::after {
  content: "";
  clear: both;
  display: table;
}

.team-button {
    border: none;
    outline: 0;
    display: inline-block;
    padding: 8px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 100%;
}

.team-button:hover {
    background-color: #555;
}

</style>