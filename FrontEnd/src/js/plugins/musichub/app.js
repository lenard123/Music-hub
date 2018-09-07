import uploader from './uploader.vue';
import carousel from './carousel.vue';

let config = {
	icon: 'images/musichub.jpg',
	baseurl: 'http://localhost:8000/',
	team: [
		{
			image:'../images/team-maurene.jpg', 
			name: 'Maurene Ordono', 
			role: 'Web Designer',
			description: 'Try and try until you succeed.',
			contact: 'maurene_ordono@gmail.com'
		},

		{
			image:'../images/team-lenard.jpg', 
			name: 'Lenard Mangay-ayam', 
			role: 'Web Developer',
			description: 'Time is gold.',
			contact: 'lenard.mangayayam@gmail.com'
		},

		{
			image:'../images/team-aj.jpg', 
			name: 'AJ Escanillas', 
			role: 'Web Designer',
			description: '~~~~~.',
			contact: 'aj@gmail.com'
		},

		{
			image:'../images/team-patricia.jpg', 
			name: 'Patricia Ebueza', 
			role: 'Web Designer',
			description: '~~~~~.',
			contact: 'patricia@gmail.com'
		},

		{
			image:'../images/team-haidy.jpg', 
			name: 'Haidy Bulandres', 
			role: 'Web Designer',
			description: '~~~~~.',
			contact: 'haidy@gmail.com'
		}
	]
}

let l = {};
l.install = function (Vue, option) {
	Vue.prototype.$l = {
		/**
		 * Show Notification
		 * @param 	{String}	title
		 * @param 	{String}	text
		 * @param 	{String}	type 	(warn|error|success)
		 */
		notify: function(title, text, type) {
			Vue.notify({
				group: 'all',
				title:title,
				text:text,
				type: type
			})
		},

		/**
		 * Handle HTTP request error
		 * @param 	{Object}	error
		 */
		handleError: function(error) {
			if (error.response.status === 422) 
				this.validationError(error.response.data.errors);
			else
				this.notify('Failed!', 'An error occured.', 'error');
		},

		/**
		 * Handle Validation Error
		 * @param 	{Object[]}	errors
		 */
		validationError: function(errors) {
			for (var error in errors) {
				for (var message in errors[error]) {
					this.notify(error, errors[error][message], 'error');
				}
			}
		},

		/**
		 * Check if there's already a token
		 * @return 	{Boolean}	hasToken
		 */
		hasToken: function() {
			return localStorage['token'] !== undefined;
		},

		/**
		 * Add default header
		 */
		setAuthorization: function() {
			axios.defaults.headers.common['Authorization'] = localStorage['token'];
		},

		/**
		 * Save token and set authorization of axios
		 * @param 	{String}	token
		 */
		setToken: function (token) {
			localStorage['token'] = 'Bearer '+token;
			this.setAuthorization();
		},

		/**
		 * Get the file from input
		 * @param 	{String}	id
		 * @return	{File}		file
		 * @return 	{Boolean}	(false) if no file
		 */
		getFile: function (fileId) {
			let file = document.getElementById(fileId);
			if (file.files && file.files[0])
				return file.files[0];
			return false;
		},

		/** 
		 * Replace whitespace to <br/>
		 * @param 	{String}	text
		 */
		lineBreak: function(string) {
			return string.replace(/\n/g, function(x) {
				return '<br/>';
			});
		},

		/**
		 * Read file
		 * @param 	{String}	inputId
		 * @param 	{String}	outputId
		 */
		readFile: function (inputId, outputId, store = 'src') {
			let input = this.getFile(inputId);
			let output = document.getElementById(output);
			if (input !== false)
				out[store] = URL.createObjectURL(input);
		}


	}

	Vue.prototype.log = function (data) {
		option.mode === 'debug' && console.log(data);
	}

	Vue.prototype.config = config

	Vue.component('l-uploader', uploader);
	Vue.component('l-carousel', carousel);

}

export default l;