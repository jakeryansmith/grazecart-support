<template>
	<div>
		<div class="panel">
			<div class="panel-heading flex align-items-m">
				<div class="flex-item">
					Guides
				</div>
				<div class="flex-item push-right">	
					<button type="button" class="btn btn-alt btn-sm" @click="showModal('createGuideModal')"><i class="fa fa-plus-circle fa-lg"></i> Add Guide</button>
				</div>
			</div>
			<div class="panel-body">
				<ul class="draggable-list" v-sortable="options">
					<li v-for="guide in guides" :key="guide.id" class="flex align-items-m">
						<span 
							class="fa draghandle flex-item mr-sm" 
							title="Drag to reorder"
						></span>
						<div class="flex-item">
							<a :href="'/admin/guides/'+guide.id+'/edit'">{{ guide.title }}</a>
						</div>
						<div class="push-right flex-item">
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="editGuide(guide)">Edit</button>
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="removeFaq(guide)">Delete</button>
						</div>
					</li>
				</ul>
				<div v-show="!guides.length">No guides found</div>
			</div>
		</div>		

		<div class="gc-modal gc-modal-mask" id="createGuideModal" @click="hideModal('createGuideModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Create Guide
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Title</label>
							<input type="text" class="form-control" v-model="guide.title">
						</div>
						<div class="form-group">
							<label>
								<input type="checkbox" v-model="guide.visible" value="1"> Visible
							</label>
						</div>
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('createGuideModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="storeGuide(guide)" :disabled="!guide.title.length">Create Guide</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="removeFaqModal" @click="hideModal('removeFaqModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Remove Guide
					</div>
					
					<div class="gc-modal-body">
						Remove <strong>{{ guide.title }}</strong>?
					</div>	
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('removeFaqModal')">Cancel</button>
		                <button type="button" class="btn btn-danger" @click="destroyFaq(guide)" :disabled="!guide.title.length">Remove Guide</button>
					</div>
				</div>
			</div>
		</div>
	</div>	
</template>

<script>
	export default {
		created: function() {
			this.fetchFaqs();
		},

		data: function() {
			return {
				guides: [],
				guideCategories: [],
				guide: {
					category_id: 0,
					title: '',
					body: '',
					keywords: '',
					visible: false
				},
				options: { 
                    onUpdate: this.updateGuideSortOrder, 
                    handle: '.draghandle', 
                    animation: 150,
                    group: {
                        name:'segments',
                        pull: false,
                        put: true
                    } 
                }
			}
		},

		methods: {
			fetchFaqs: function() {
				axios.get('/api/guides').then(function(response) {
					this.guides = response.data;
				}.bind(this))
				.catch(function(error) {

				});
			},

			// fetchFaqCategores: function() {
			// 	axios.get('/api/guide-categories').then(function(response) {
			// 		this.guideCategories = response.data;
			// 	}.bind(this))
			// 	.catch(function(error) {

			// 	});
			// },

			storeGuide: function(guide) {
				eventHub.$emit('showProgressBar');
				axios.post('/api/guides', guide).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('createGuideModal');
					this.fetchFaqs();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			editGuide: function(guide) {
				window.href = guide.slug;
			},

			updateGuide: function(guide) {
				eventHub.$emit('showProgressBar');
				axios.put('/api/guides/'+guide.id, guide).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('editGuideModal');
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},

			updateGuideSortOrder: function(event)
			{
				eventHub.$emit('showProgressBar');
				this.guides.splice(event.newIndex, 0, this.guides.splice(event.oldIndex, 1)[0]);

				for(let i = 0; i < this.guides.length; i++) {
					let guide = this.guides[i];
					guide.sort_order = i;
					this.updateGuide(guide);
				}
			},

			removeFaq: function(guide) {
				this.guide = guide;
				this.showModal('removeFaqModal');
			},

			destroyFaq: function(guide) {
				eventHub.$emit('showProgressBar');
				axios.delete('/api/guides/'+guide.id).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('removeFaqModal');
					this.fetchFaqs();
				}.bind(this))
				.catch(function(error) {
					eventHub.$emit('hideProgressBar');
				});
			},
		}
	}
</script>