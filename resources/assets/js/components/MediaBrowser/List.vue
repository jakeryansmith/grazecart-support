<template>
	<div class="mediaBrowser-gallery-list">
	    <table>
	    	<tr v-for="photo in photos.data">
	    		<td>
	        		<a v-bind:href="photo.path" target="_blank">
	        			<img v-bind:src="photo.thumbnail_path">
	        		</a>
	        	</td>
	        	<td>
	        		<div class="fs-1 bold mb-xs">{{ photo.title }}</div>
	        		<div class="fs-sm text-gray-medium">Added {{ photo.created_at_formatted }}</div>
	        	</td>
	        	<td><button type="button" class="btn btn-default" @click="select(photo)">Insert</button></td>	
	    	</tr>
	    </table>
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