<template>
<div>	
	<div class="carousel-container">
		<div class="carousel-slides fade" v-for="(item,i) in data">
			<div class="carousel-indicator">{{ i+1 }} / {{ data.length }}</div>
			<img :src="item.image" style="max-width: 670px; height: auto;"/>
		</div>

		<a class="carousel-prev" @click="plusSlides(-1)">&#10094;</a>
		<a class="carousel-next" @click="plusSlides(1)">&#10095;</a>
	</div>
	<br/>
	<div style="text-align: center;">
		<span class="carousel-dot" @click="currentSlide(i+1)" v-for="(item,i) in data"></span>
	</div>
</div>
</template>

<style>
* {box-sizing:border-box;}

.carousel-container {
  position: relative;
  margin: auto;
  background-color: gray;
}

.carousel-slides {
    display: none;
    text-align: center;
    position: relative;
}

/* Next & previous buttons */
.carousel-prev, .carousel-next {
  cursor: pointer;
  position: absolute;
  top: 30%;
  width: auto;
  padding: 16px;
  color: rgb(200, 200, 200);
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
}

/* Position the "next button" to the right */
.carousel-next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.carousel-prev:hover, .carousel-next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Number text (1/3 etc) */
.carousel-indicator {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  bottom: 0px;
  width: 100%;
}

/* The dots/bullets/indicators */
.carousel-dot {
  cursor:pointer;
  height: 13px;
  width: 13px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.carousel-active, .carousel-dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

</style>

<script>
export default{
	props: ['data'],
	
	data: ()=>({
		slideIndex: 1
	}),

	created: function () {
		this.$nextTick(()=>this.autoPlay());
	},

	methods: {

		autoPlay: function () {
			this.plusSlides(1);
			setTimeout(()=>this.autoPlay(), 3000);
		},

		plusSlides: function (n) {
			this.showSlide(this.slideIndex+=n);
		},

		currentSlide: function (n) {
			this.showSlide(this.slideIndex=n);
		},

		showSlide: function (n) {
			let i;
			let slides = document.getElementsByClassName('carousel-slides');
			let dots = document.getElementsByClassName('carousel-dot');
			
			if (n < 1) this.slideIndex = slides.length;
			if (n > slides.length) this.slideIndex = 1;

			for (i=0; i < slides.length; i++) 
				slides[i].style.display = 'none';

			for (i=0;i < dots.length; i++)
				dots[i].className = dots[i].className.replace(" carousel-active", "");

			slides[this.slideIndex-1].style.display = 'block';
			dots[this.slideIndex-1].className += " carousel-active"; 

		}
	}
}
</script>