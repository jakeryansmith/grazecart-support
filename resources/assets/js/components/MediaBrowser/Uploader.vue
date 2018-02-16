<template>
<form action="" class="dropzone" id="mediaUpload" v-show="show">
    <div class="dz-message">
        <strong>Drop files here or click to upload.</strong><br />
        <small>(Max file size: 1MB)</small>
    </div>
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</form>
</template>

<script>
	import Dropzone from 'Dropzone';
	export default {
		props: {
			show: {
				required: false,
				default: false
			},
			tags: {
				type: Array,
				required: false,
				default: function() {
					return null
				}
			}
		},

		mounted: function()
		{
			console.log(this.tags);
			var that = this
			Dropzone.autoDiscover = false;
			new Dropzone("#mediaUpload", 
				{ 
					headers: {'X-CSRF-TOKEN': document.querySelector('#csrf-token').getAttribute('value')},
					paramName: "file",
					maxFilesize: 1,
            		acceptedFiles: 'image/jpg,image/jpeg,image/png,application/pdf',
					url: "/api/photos",
					params: {
						tags: this.tags
					},
					init: function()
					{
						this.on('success', function(e, response)
						{

						})

						this.on('error', function(e, response)
						{
							alert(response);
						})

						this.on('queuecomplete', function(e, response)
						{
							that.$parent.getFiles(1);
							that.$parent.showUploader = false;
							this.removeAllFiles();
						})
					}
				}
			);
		}
	}
</script>

<style>
	.dropzone {
		margin: 30px;
	}
</style>