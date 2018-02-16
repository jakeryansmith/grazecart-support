<template>
	<div class="mediaBrowser-gallery-grid">
		<div class="mediaBrowser-gallery-container" v-for="photo in photos.data">
	    	<div class="mediaBrowser-image-container">
	    		<a v-bind:href="photo.path" target="_blank">
	    			<img v-bind:src="photo.thumbnail_path">
	    		</a>
	    	</div>
	    	<div class="mediaBrowser-image-title">
	    		<h3>{{ photo.title }}</h3>
	    		<button type="button" class="btn btn-sm btn-default btn-block" @click="select(photo)">Insert</button>
	    	</div>
	    </div>
	</div>
</template>

<script>
	export default {
		props: ['photos'],

		methods: {
			select: function(photo)
			{
				this.$emit('input', photo);
			}
		}
	} 
</script>