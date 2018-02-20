<template>
<div>
	<transition name="fade">
	<div class="mediaBrowser" v-if="show">
		<div class="mediaBrowser-header">
			<div class="mediaBrowser-heading">
				<div class="mediaBrowser-title">
					<h2>Photo Browser</h2>
				</div>
				<div class="mediaBrowser-close">
					<a href="#" @click="toggle()"><i class="fa fa-times"></i> Close</a>
				</div>
			</div>	
			<div class="mediaBrowser-toolbar">
				<div class="flex align-items-m">
					<div class="flex-item mr-sm">
						<!-- Search -->
						<div class="input-group">
							<input type="text" class="form-control" v-model="query" placeholder="Search photos..." 
							@keypress.enter="getFiles()">
					    		<button  type="button" class="br--r br-left-0 btn btn-light input-group-append" @click="getFiles()">
					    			<i class="fa fa-search"></i>
					    		</button>
					    </div>
					</div>
					<div class="flex-item-fill text-right">
						<button 
								type="button" 
								class="btn btn-light" 
								v-bind:class="'btn btn-light ' + source == 'uploads' ? 'active' : ''" 
								@click="getFiles(page)"
						>My Uploads</button>
						
						<button type="button" class="btn btn-light" @click="view = 'List'"><i class="fa fa-bars"></i></button>

						<button type="button" class="btn btn-light" @click="view = 'Grid'"><i class="fa fa-th"></i></button>
						<button type="button" class="btn btn-light" @click="showUploader = !showUploader">
							<i class="fa fa-cloud-upload"></i> <span class="hidden-sm hidden-xs">Upload</span>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="mediaBrowser-body">

			<uploader :show="showUploader" :tags="tags"></uploader>

			<!-- Gallery -->
			<div class="mediaBrowser-gallery">
            	<div v-if="!photos.data.length">
            		<div class="fs-2 bold mt-md">No photos</div>
            	</div>
            	<component :is="view" :photos="photos" v-on:input="select"></component>
		         
            </div>
            <!-- End gallery -->
            <div class="mediaBrowser-footer">
				<div class="btn-group">
                    <button class="btn btn-default" @click="prevPage()" v-bind:disabled="firstPage">
                    	<i class="fa fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-default" disabled>
                    	Page: {{ photos.current_page }} of {{ photos.last_page }}
                    </button>
                    <button class="btn btn-default" @click="nextPage()" v-bind:disabled="lastPage">
                    	<i class="fa fa-chevron-right"></i>
                    </button>
                </div>
			</div>

		</div>
	</div>
	</transition>
</div>	
</template>

<script>
	import Uploader from './Uploader.vue';
	import List from './List.vue';
	import Grid from './Grid.vue';
	import Stock from './StockGallery.vue';
	export default {

		props: {
			tags: {
				type: Array,
				required: false,
				default: function() {
					return null
				}
			},
			id: {
				type: String,
				required: false
			}
		},

		components: {
			Uploader, List, Grid, Stock
		},	

		created: function()
		{
			this.getFiles(1);
			eventHub.$on('toggleMediaBrowser', this.toggle);
			this.$on('toggle', function() {
				this.toggle();
			}.bind(this));
		},

		data: function()
		{
			return {
				show: false,
				photos: {},
				stockPhotos: {},
				photo: '',
				query: '',
				showUploader: false,
				view: 'List',
				mode: '',
				source: 'uploads',
				page: 1,
				redactor: '',
			}	
		},

		computed: {
	        firstPage: function() {
	            return this.photos.current_page === 1;
	        },
	        lastPage: function() {
	            return this.photos.current_page === this.photos.last_page || !this.photos.data.length;
	        },
	        smallOption: function() {
	            var height = Math.round(this.photo.height * 0.25);
	            var width = Math.round(this.photo.width * 0.25);
	            return {'width': width, 'height': height};
	        },
	        mediumOption: function() {
	            var height = Math.round(this.photo.height * 0.5);
	            var width = Math.round(this.photo.width * 0.5);
	            return {'width': width, 'height': height};
	        },
	        largeOption: function() {
	            var height = this.photo.height;
	            var width = this.photo.width;
	            return {'width': width, 'height': height};
	        }
	    },

		events: {
			'mediaBrowser:toggle': function(params) {
				this.toggle();
			}
		},

		methods: {
			getFiles: function(page) {
				this.source = 'uploads';
				this.page = page;
				eventHub.$emit('showProgressBar');
	            var data = {
	                page: page,
	                type: 'image',
	                q: this.query
	            };

	            axios.get('/api/photos', {params: data})
	            	.then(function (response) {
                    	this.photos = response.data;
                    	console.log(response.data);
                    	eventHub.$emit('hideProgressBar');
	                }.bind(this))
	            	.catch(function(error) {
	                	eventHub.$emit('hideProgressBar');
	                })
	        },

	        getStockFiles: function()
			{
				alert('No stock photos');
			},

	        select: function(photo)
	        {

	        	var redactor = $('#body_content').redactor('core.object');
	        	redactor.insert.html('<img src="'+photo.path+'" alt="'+photo.title+'">');

	        	this.toggle();
	        },

	        editItem: function(photo)
	        {
	        	this.photo = photo;
	        },

			toggle: function()
			{
				this.show = !this.show;
				if(this.show)
				{
					document.body.style.overflow = "hidden";
				}
				else
				{
					document.body.style.overflow = "auto";
				}
			},

			prevPage: function()
	        {
	            if(this.photos.current_page > 0)
	            {
	                this.getFiles(this.photos.current_page - 1);
	            }
	        },

	        nextPage: function()
	        {
	            if(this.photos.current_page < this.photos.last_page)
	            {
	                this.getFiles(this.photos.current_page + 1);
	            }
	        },

	        InsertCodeInTextArea: function(photo) {
		        //Get textArea HTML control 
		        var txtArea = document.getElementById("body_content");
		        let textValue = "!['"+photo.title+"']("+photo.path+")";

		        //IE
		        if (document.selection) {
		            txtArea.focus();
		            var sel = document.selection.createRange();
		            sel.text = textValue;
		            return;
		        }
		        //Firefox, chrome, mozilla
		        else if (txtArea.selectionStart || txtArea.selectionStart == '0') {
		            var startPos = txtArea.selectionStart;
		            var endPos = txtArea.selectionEnd;
		            var scrollTop = txtArea.scrollTop;
		            txtArea.value = txtArea.value.substring(0, startPos) + textValue + txtArea.value.substring(endPos, txtArea.value.length);
		            txtArea.focus();
		            txtArea.selectionStart = startPos + textValue.length;
		            txtArea.selectionEnd = startPos + textValue.length;
		        }
		        else {
		            txtArea.value += textArea.value;
		            txtArea.focus();
		        }

		        this.toggle();
		    }
		}

	}
</script>