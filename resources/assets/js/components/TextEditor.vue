<template>
	<div>
		<textarea 
			:name="name" 
			:rows="rows" 
			v-model="sectionContent" 
			class="form-control" 
			@change="$emit('input', $event.target.value)"
		></textarea>
		<media-browser ref="mediaBrowser" v-on:insertPhoto="insertPhoto"></media-browser>
	</div>
</template>

<script>
	import MediaBrowser from './MediaBrowser/MediaBrowser.vue'
	export default {
		components: {
			MediaBrowser
		},

		props: {
			offset: 
			{
				type: Number,
				default: 63
			},
			fixed:
			{
				type: Boolean,
				default: true
			},
			content: 
			{
				type: String,
				required: false
			},
			name: 
			{
				type: String,
				required: true
			},
			rows: 
			{
				type: Number,
				default: 10
			}
		},

		data: function()
		{
			let that = this
			return {
				sectionContent: '',
				settings: {
				    buttons: ['bold', 'italic', 'link', 'lists'],
				    plugins: ['imagePlus','video','historybuttons','source','fullscreen'],
				    formatting: [],
				    pastePlainText: true,
				    imageResizable: true,
				    script: false,
				    structure: true,
				    toolbarFixed: this.fixed,
				    toolbarFixedTopOffset: this.offset,
				    minHeight: 400,
				    toolbarOverflow: true,
				    callbacks: {
				        change: function(e)
				        {
				            that.$emit('input', this.code.get());
				        }
				    }   
				},
				redactor: null
			}
		},
		created: function() {
			this.$on('insertPhoto', function(photo) {
				this.insertPhoto(photo);
			});
			// eventHub.$on('editSection', function(segment) {
			// 	this.redactor.code.set(segment.body);
			// }.bind(this));
		},

		
		mounted: function()
		{
			this.sectionContent = '';
			console.log(this.sectionContent);
			let thisComponent = this
			// Build Image plugin
			$.Redactor.prototype.imagePlus = function()
		    {
		        return {
		            init: function ()
		            {
		                var button = this.button.add('imagePlus', 'Image');
		                this.button.addCallback(button, this.imagePlus.toggleMediaBrowser);
		            },
		            toggleMediaBrowser: function()
		            {
		                thisComponent.$refs.mediaBrowser.$emit('toggle');
		            }
		        }
		    }

		    // Build Video plugin
		    $.Redactor.prototype.video = function()
			{
			    return {
			        getTemplate: function()
			        {
			            return String()
			            + '<div class="modal-section" id="redactor-modal-advanced">'
			                + '<section>'
			                    + '<label>YouTube/Vimeo embed code</label>'
			                    + '<textarea id="videomodal-textarea" rows="12"></textarea>'
			                + '</section>'
			                + '<section>'
			                    + '<button id="redactor-modal-button-action">Insert</button>'
			                    + '<button id="redactor-modal-button-cancel">Cancel</button>'
			                + '</section>'
			            + '</div>';
			        },
			        init: function ()
			        {
			            var button = this.button.add('video', 'Video');
			            this.button.addCallback(button, this.video.show);
			        },
			        show: function()
			        {
			            this.modal.addTemplate('video', this.video.getTemplate());
			            this.modal.load('video', 'Add a YouTube/Vimeo Video', 400);

			            var button = this.modal.getActionButton();
			            button.on('click', this.video.insert);

			            this.modal.show();

			            $('#videomodal-textarea').focus();
			        },
			        insert: function()
			        {
			            var html = $('#videomodal-textarea').val();

			            var content = '<div class="video-container">'+html+'</div>'
			            this.modal.close();
			            this.insert.html(content);
			        }
			    };
			};
			
			// Vue.nextTick(function () {
			//   	$('#'+this.name+'Editor').redactor(this.settings);
			// 	this.redactor = $('#'+this.name+'Editor').redactor('core.object');
			// }.bind(this));
		},

		methods: {
			insertPhoto: function(photo) {
				this.redactor.insert.html('<img src="'+photo.path+'" alt="'+photo.title+'">')
			}
		}
	}
</script>