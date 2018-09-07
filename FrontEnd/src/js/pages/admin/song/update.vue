<template>
<div class="box column is-two-thirds content">
	<h4>Add Song</h4>
	<hr/>

	<form class="columns" @submit.prevent="updateSong()">
		<div class="column is-one-thirds center">
			<l-uploader file-id="image" :img-src="config.baseurl+'storage/'+song.image" />
			<audio controls class="w-200px" id="music" :src="config.baseurl+'storage/'+song.music"></audio>
		</div>

		<div class="column">

			<div class="field">
				<label class="label">Select Music</label>
				<div class="file has-name" :class="{'is-loading':loading}">
					<label class="file-label w-max">
						<input class="file-input" type="file" name="music" id="file" @change="readFile('file', 'music')"/>
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
						<select required v-model="song.category_id" style="width: 100%;">
							<option value="0" disabled selected>-- Select Category --</option>
							<option v-for="category in categories" :value="category.id">{{ category.name }}</option>
						</select>
					</div>
				</div>
			</div>

			<div class="field">
				<label class="label">Title</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="song.title" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Singer</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" class="input" v-model="song.singer" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Composer</label>
				<div class="control" :class="{'is-loading':loading}">
					<input type="text" v-model="song.composer" class="input" required/>
				</div>
			</div>

			<div class="field">
				<label class="label">Lyrics</label>
				<div class="control" :class="{'is-loading':loading}">
					<textarea required v-model="song.lyrics" class="input" style="height: 100%;"></textarea>
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
		song: {},
		loading: false,
		filename: 'No file selected'
	}),

	created: function () {
		this.song = this.getSong();
	},

	methods: {
		updateSong: function () {
			if (this.loading) return
			this.loading = true;

			let data = this.getData();
			let config = {headers:{'Content-Type': `multipart/form-data; boundary=${data._boundary}`}}

			axios.post(this.config.baseurl+'api/v1/song/'+this.id, data, config)
				.then((response)=>this.success(response))
				.catch((error)=>this.failed(error))
				.then(()=>{this.loading=false});
		},

		success: function (response) {
			this.log(response);
			this.$l.notify('Success', 'Song updated successfully', 'success');
		},

		failed: function (error) {
			this.log(error);
			this.$l.handleError(error);
		},

		getData: function () {
			let data = new FormData();
			let image = this.$l.getFile('image');
			let music = this.$l.getFile('file');

			data.append('category_id', this.song.category_id);
			data.append('title', this.song.title);
			data.append('singer', this.song.singer);
			data.append('composer', this.song.composer);
			data.append('lyrics', this.song.lyrics);			
			data.append('_method', 'PUT');

			if (image !== false)
				data.append('image', image, image.filename);
			if (music !== false)
				data.append('music', music, music.filename);

			return data;			
		},

		readFile: function(fileId, outputId) {
			this.$l.readFile(fileId, outputId);
			this.filename = this.$l.getFile(fileId).name;
		},

		getSong: function () {
			let songs = this.songs;
			for (let i in songs) 
				if (songs[i].id == this.id)
					return songs[i];
			return {};
		}		
	},

	computed: {
		id: function () {
			return this.$route.params.id;
		},
		songs: function () {
			return this.$store.state.songs;
		},
		categories: function () {
			return this.$store.state.categories;
		}
	}
}
</script>