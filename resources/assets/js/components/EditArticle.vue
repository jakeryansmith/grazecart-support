<template>
	<div>
		<div class="panel">
			<div class="panel-heading flex align-items-m">
				<div class="flex-item">
					Article Sections
				</div>
				<div class="flex-item push-right">	
					<button type="button" class="btn btn-alt btn-sm" @click="showModal('createSectionModal')"><i class="fa fa-plus-circle fa-lg"></i> Add Section</button>
				</div>
			</div>
			<div class="panel-body">
				<ul class="draggable-list" v-sortable="options">
					<li v-for="section in sections" :key="section.id" class="flex align-items-m">
						<span 
							class="fa draghandle flex-item mr-sm" 
							title="Drag to reorder"
						></span>
						<div class="flex-item"><a :href="'/admin/topics/'+topic.slug+'/articles/'+article.slug+'/sections/'+section.slug+'/edit'">{{ section.title }}</a></div>
						<div class="push-right flex-item">
							<a :href="'/admin/topics/'+topic.slug+'/articles/'+article.slug+'/sections/'+section.slug" class="btn btn-alt btn-link btn-sm pt-0 pb-0">Edit</a>
							<button type="button" class="btn btn-alt btn-link btn-sm pt-0 pb-0" @click="removeSection(section)">Delete</button>
						</div>
					</li>
				</ul>
				<div v-show="!sections.length">No sections found</div>
			</div>
		</div>		
			
		<div class="gc-modal gc-modal-mask" id="createSectionModal" @click="hideModal('createSectionModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container gc-modal-container--large" @click.stop>
					
					<div class="gc-modal-header">
						Create Section
					</div>
		
					<div class="gc-modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" v-model="section.title">
						</div>
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('createSectionModal')">Cancel</button>
		                <button type="button" class="btn btn-action" @click="storeSection(section)" :disabled="!section.title.length">Create Section</button>
					</div>
				</div>
			</div>
		</div>

		<div class="gc-modal gc-modal-mask" id="removeSectionModal" @click="hideModal('removeSectionModal')">
			<div class="gc-modal-wrapper">
				<div class="gc-modal-container" @click.stop>
					
					<div class="gc-modal-header">
						Delete Section
					</div>
		
					<div class="gc-modal-body">
						Delete this section?
					</div>
		
					<div class="gc-modal-footer">
						<button type="button" class="btn btn-alt" @click="hideModal('removeSectionModal')">Cancel</button>
		                <button type="button" class="btn btn-danger" @click="destroySection(section)">Delete Section</button>
					</div>
				</div>
			</div>
		</div>
	</div>	
</template>

<script>
	import TextEditor from './TextEditor.vue';
	export default {
		props: ['topic','article'],

		components: {TextEditor},

		created: function() {
			this.resetSection();
			this.fetchSections();
			eventHub.$on('editSectionModal:closed', this.resetSection);
		},

		data: function() {
			return {
				sections: [],
				section: {},
				options: { 
                    onUpdate: this.updateSectionSortOrder, 
                    handle: '.draghandle', 
                    animation: 150,
                    group: {
                        name:'sections',
                        pull: false,
                        put: true
                    } 
                }
			}
		},

		methods: {
			resetSection: function() {
				this.section = {
					title: '',
					body: ''
				}
				eventHub.$emit('editSection', this.section);
			},

			fetchSections: function() {
				axios.get('/api/topics/'+this.topic.id+'/articles/'+this.article.id+'/sections').then(function(response) {
					this.sections = response.data;
				}.bind(this))
				.catch(function(error) {

				});
			},

			storeSection: function(section) {
				eventHub.$emit('showProgressBar');
				axios.post('/api/topics/'+this.topic.id+'/articles/'+this.article.id+'/sections', section).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('createSectionModal');
					this.fetchSections();
				}.bind(this))
				.catch(function(error) {
					this.hideModal('createSectionModal');
					eventHub.$emit('hideProgressBar');
				});
			},

			editSection: function(section) {
				this.section = section;
				eventHub.$emit('editSection', section);
				this.showModal('editSectionModal');
			},

			updateSection: function(section) {
				eventHub.$emit('showProgressBar');
				axios.put('/api/topics/'+this.topic.id+'/articles/'+this.article.id+'/sections/'+section.id, section).then(function(response) {
					eventHub.$emit('hideProgressBar');
				}.bind(this))
				.catch(function(error) {
					this.hideModal('editSectionModal');
					eventHub.$emit('hideProgressBar');
				});
			},

			updateSectionSortOrder: function(event)
			{
				eventHub.$emit('showProgressBar');
				this.sections.splice(event.newIndex, 0, this.sections.splice(event.oldIndex, 1)[0]);

				for(let i = 0; i < this.sections.length; i++) {
					let section = this.sections[i];
					section.sort_order = i;
					this.updateSection(section);
				}
			},

			removeSection: function(section) {
				this.section = section;
				this.showModal('removeSectionModal');
			},

			destroySection: function(section) {
				eventHub.$emit('showProgressBar');
				axios.delete('/api/topics/'+this.topic.id+'/articles/'+this.article.id+'/sections/'+section.id).then(function(response) {
					eventHub.$emit('hideProgressBar');
					this.hideModal('removeSectionModal');
					this.fetchSections();
				}.bind(this))
				.catch(function(error) {
					this.hideModal('removeSectionModal');
					eventHub.$emit('hideProgressBar');
				});
			},

			updateSectionBody: function(data) {
				this.section.body = data;
			}
		}	
	}
</script>