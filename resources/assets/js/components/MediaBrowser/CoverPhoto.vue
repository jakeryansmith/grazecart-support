<template>
<div class="CoverPhoto">
	<div class="CoverPhoto-preview" style="background-image: url('/images/grid-bg.jpg')">
		<img v-bind:src="src" v-bind:alt="src" @click.prevent="add()" class="coverPhoto__image">
    </div>
    <div v-show="src">
    	<a href="#" @click.prevent="remove()" class="text-danger">Remove photo</a>
    </div>
    <div v-else>
    	<button type="button" class="btn btn-default" @click.prevent="add()">{{ message }}</button>
    </div>
</div>
</template>

<script>
	export default {
		props: {
			url: {
				type: String,
				required: false
			},
			src: {},
			field: {},
			message: {
				default: 'Add Cover Photo'
			}
		},


		events: {
			'updateCoverPhoto': function(event)
			{
				this.update(event.photo)
			}
		},

		methods: {

			remove: function()
			{
				this.update({'photo_path': '', 'thumbnail_path': ''});
				this.src = '';
			},
			add: function() 
			{
				eventHub.$emit('mediaBrowser:toggle', {mode: 'cover-photo'})
			},
			update: function(photo)
			{	
				this.$eventHub.$emit('showProgressBar');
				this.src = photo.path;
				if(typeof this.field == 'undefined')
				{
					var field = 'photo_path'
				}
				else
				{
					var field = this.field
				}
				var payload = {};
				payload[field] = photo.path
				payload['cover_photo_thumbnail'] = photo.thumbnail_path
				console.log(payload)
	            axios({url: this.url, data: payload, method: 'PUT'}).then(function (response) {
                    this.$eventHub.$emit('hideProgressBar');
                    eventHub.$emit('coverPhotoWasUpdated', photo.path)
	                }, function (error) {
	                    this.$eventHub.$emit('hideProgressBar');
	                });
			}
		}

	}
</script>

<style>
.CoverPhoto {
	text-align: left;
}

.CoverPhoto-preview img {
	max-width: 100%;
	display: block;
	margin: 0 auto;
	margin-bottom: 10px;
}

.CoverPhoto-preview img:hover {
	opacity: 0.9;
	cursor: pointer;
}

</style>