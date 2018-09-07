<template>
<div class="box column is-two-thirds content">
	<h4>Add Song</h4>
	<hr/>

	<form class="columns" @submit.prevent="addSong()">

		<div class="column is-one-thirds center">
			<l-uploader file-id="image" />

			<audio controls class="w-200px" id="music">
				<!--<source src="#" id="music" type="audio/mpeg">-->
			</audio>
		</div>

		<div class="column">

			<div class="field">
				<label class="label">Select Music</label>
				<div class="file has-name" :class="{'is-loading':loading}">
					<label class="file-label w-max">
						<input class="file-input" id="file" type="file" name="music" @change="readFile('file', 'music')" required/>
						<span class="file-cta">
							<span class="file-icon">
								<i class="fas fa-upload"></i>
							</span>
							<span class="file-label">
							Choose a file…
							</span>
						</span>
						<span class="file-name w-max">
							{{ filename }}
						</span>
					</label>
				</div>	
			</div>

			<div class="field">
				<label class="label">Category</label>
				<div class="control" :class="{'is-loading':loading}">
					<div class="select" style="width: 100%;">
						<select required v-model="category_id" style="width: 100%;">
							<option value="0" disabled selected>-- Select Category --</option>
							<option v-for="category in categories" :value="category.id">{{ category.name }}</option>
						</select>
					</div>
				</div>
			</div>

			<div class="field">
				<label class="label">Title</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="title" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Singer</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" class="input" v-model="singer"/>
				</div>
			</div>

			<div class="field">
				<label class="label">Composer</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="composer" class="input"/>
				</div>
			</div>

			<div class="field">
				<label class="label">Lyrics</label>
				<div class="control" :class="{'is-loading':loading}">
					<textarea required v-model="lyrics" class="input" style="height: 100%;"></textarea>
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
	data: ()=>({
		loading: false,
		category_id: 0,
		title: '',
		singer: '',
		composer: '',
		lyrics: '',
		filename: 'No file selected'
	}),

	methods: {

		addSong: function () {
			if (this.loading) return;
			this.loading = true;

			let data = this.getData();
			let config = {headers:{'Content-Type': `multipart/form-data; boundary=${data._boundary}`}}

			axios.post(this.config.baseurl+'api/v1/song', data, config)
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
			this.$l.notify('Success', 'Song added successfully.', 'success');
		},

		getData: function () {
			let data = new FormData();
			let image = this.getFile('image');
			let music = this.getFile('file');

			data.append('category_id', this.category_id);
			data.append('title', this.title);
			data.append('singer', this.singer);
			data.append('composer', this.composer);
			data.append('lyrics', this.lyrics);

			if (image !== false)
				data.append('image', image, image.name);
			if (music !== false)
				data.append('music', music, music.name);

			return data;

		},

		getFile: function (fileId) {
			return this.$l.getFile(fileId);

		},

		readFile: function (fileId, srcId) {
			let input = document.getElementById(fileId);
			let output = document.getElementById(srcId);
			output.src = URL.createObjectURL(input.files[0]);
			this.filename = input.files[0].name;
		}
	},

	computed: {
		categories: function () {
			return this.$store.state.categories;
		}
	}
}
</script>
